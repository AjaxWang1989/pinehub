<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchandiseCategoryRepository.
 *
 * @package namespace App\Repositories;
 */
interface MerchandiseCategoryRepository extends RepositoryInterface
{
    /**
     * @param int $id
     * @return $MerchandiseCategory
     */
    public function  merchandises(int $id);
}
