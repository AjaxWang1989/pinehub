<?php

namespace App\Criteria\Admin;

use App\Entities\Card;
use App\Services\AppManager;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CardCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class CardCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Card $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $model = $model->whereAppId($appManager->currentApp->id);
        if($appManager->officialAccount)
            $model = $model->whereWechatAppId($appManager->officialAccount->appId);
        $cardType = Request::input('card_type', null);
        if($cardType) {
            return $model->whereCardType($cardType);
        }else{
            return $model->whereIn('card_type', [Card::GROUPON, Card::DISCOUNT, Card::COUPON_CARD, Card::GIFT]);
        }

    }
}
