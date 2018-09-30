<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShopMerchandiseRepository.
 * @package namespace App\Repositories;
 */
interface ShopMerchandiseRepository extends RepositoryInterface
{
    /**
     * @param int $id
     */
    public function storeCategories(int $id);

    /**
     * @param int $id
     * @param int $categoryId
     */
    public function storeCategoryMerchandises(int $id ,int $categoryId);

    /**
     * @param $store
     * @return mixed
     */
    public function storeStockMerchandise($store);
}
