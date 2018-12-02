<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 14:50
 */

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShoppingCartRepository.
 *
 * @package namespace App\Repositories;
 */
interface ShoppingCartRepository extends RepositoryInterface
{
    /**
     * @param int $storeId
     * @param int|null $activityMerchandiseId
     * @param int $userId
     * @return mixed
     */
    public function shoppingCartMerchandises(int $storeId = null,int $activityMerchandiseId = null,$userId);

}