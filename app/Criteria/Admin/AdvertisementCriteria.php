<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-20
 * Time: 下午7:34
 */

namespace App\Criteria\Admin;

use App\Entities\Advertisement;
use App\Services\AppManager;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class AdvertisementCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param  Advertisement $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $model = $model->whereAppId($appManager->currentApp->id);
        if ($appManager->officialAccount) {
            $model = $model->whereWechatAppId($appManager->officialAccount->appId);
        }
        return $model;
    }
}
