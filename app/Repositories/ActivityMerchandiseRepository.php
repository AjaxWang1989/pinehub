<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ActivityMerchandiseRepository.
 *
 * @package namespace App\Repositories;
 */
interface ActivityMerchandiseRepository extends RepositoryInterface
{
    /**
     * @param int $activityId
     * @param int $userId
     * @return mixed
     */
    public function newActivityMerchandise(int $activityId,int $userId);
}
