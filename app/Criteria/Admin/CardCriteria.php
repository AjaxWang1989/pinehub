<?php

namespace App\Criteria\Admin;

use App\Entities\Card;
use App\Services\AppManager;
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
        return $model->whereAppId($appManager->currentApp->id)
            ->whereWechatAppId($appManager->officialAccount->appId)
            ->whereIn('card_type', [Card::GROUPON, Card::DISCOUNT, Card::COUPON_CARD, Card::GIFT]);
    }
}
