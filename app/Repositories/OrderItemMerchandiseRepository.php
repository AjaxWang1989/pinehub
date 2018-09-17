<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderItemMerchandiseRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderItemMerchandiseRepository extends RepositoryInterface
{
    //
    /**
     * @param int $userId
     * @return mixed
     */
    public function orderItemUser(int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sellMerchandiseNum(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sellTop(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sellMerchandiseTop(array $request,int $userId);
}
