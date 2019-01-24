<?php

namespace App\Repositories;

use App\Entities\ShopManager;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShopManagerRepository.
 *
 * @package namespace App\Repositories;
 */
interface ShopManagerRepository extends RepositoryInterface
{
    //
    /**
     * @param string $mobile
     * @return ShopManager
     * */
    public function  whereMobile(string  $mobile);
}
