<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-19
 * Time: 下午5:11
 */

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface AdvertisementRepository extends RepositoryInterface
{
    public function pushCriteria($class);

    public function getAdvertisements();
}