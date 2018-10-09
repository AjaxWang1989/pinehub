<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchandiseRepository.
 *
 * @package namespace App\Repositories;
 */
interface MerchandiseRepository extends RepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function findMerchandises(string $name);

    /**
     * @param string $name
     * @return mixed
     */
    public function searchMerchandises(string $name);
}
