<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ActivityRepository.
 *
 * @package namespace App\Repositories;
 */
interface ActivityRepository extends RepositoryInterface
{
    public function newActivity();

    public function first();
}
