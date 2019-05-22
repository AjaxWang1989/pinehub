<?php

namespace App\Repositories;

use App\Entities\RechargeableCard;
use App\Entities\User;
use App\Entities\UserRechargeableCard;
use App\Repositories\Traits\Destruct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'user_name' => 'like',
        'nickname' => 'like',
        'mobile' => '=',
        'sex' => '=',
        'roles.slug' => '=',
        'roles.display_name' => 'like',
        'roles.group.display_name' => 'like',
        'channel' => '=',
        'register_channel' => '=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {

    }

    /**
     * 计算余额
     * @param User $user
     * @return float|int|string
     */
    public function getBalance(User $user)
    {
        $balance = 0;
        if ($user->balance) {
            $balance += $user->balance * 100;
        }

        $userRechargeableCards = $user->rechargeableCardRecords()->with([
            'rechargeableCard' => function ($query) {
                $query->withTrashed()->where('card_type', RechargeableCard::CARD_TYPE_DEPOSIT);
            }
        ])->where('status', '=', UserRechargeableCard::STATUS_VALID)->orderBy('created_at', 'asc')->get();

        $limitCard = false;
        $today = Carbon::now();
        /** @var UserRechargeableCard $userRechargeableCard */
        foreach ($userRechargeableCards as $userRechargeableCard) {
            $rechargeableCard = $userRechargeableCard->rechargeableCard;
            Log::info('%%%%%卡片%%%%%：', [$rechargeableCard]);
            if ($rechargeableCard->type === RechargeableCard::TYPE_INDEFINITE) {
                $balance += $userRechargeableCard->amount;
            } else if (!$limitCard && $today->gte($userRechargeableCard->validAt->startOfDay()) && $today->lte($userRechargeableCard->invalidAt->startOfDay())) {
                $balance += $userRechargeableCard->amount;
                $limitCard = true;
            }
        }

        $balance = number_format($balance / 100, 2);

        return $balance;
    }
}
