<?php
/**
 * UserRechargeableCardRepositoryEloquent.php
 * User: katherine
 * Date: 19-5-19 下午6:35
 */

namespace App\Repositories;

use App\Entities\UserRechargeableCard;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRechargeableCardRepositoryEloquent extends BaseRepository implements UserRechargeableCardRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserRechargeableCard::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}