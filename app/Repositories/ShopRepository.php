<?php

namespace App\Repositories;

use App\Entities\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Array_;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShopRepository.
 *
 * @package namespace App\Repositories;
 */
interface ShopRepository extends RepositoryInterface
{
    /**
     * @param float $lng
     * @param float $lat
     * @param float $distance
     * @return Shop
     * */
    public function nearest(float $lng, float $lat, float $distance = 15);

    /**
     * @param float $lng
     * @param float $lat
     * @param float $distance
     * @return Collection|Array
     * */
    public function nearBy(float $lng, float $lat, float $distance = 15, $limit = 15);
}
