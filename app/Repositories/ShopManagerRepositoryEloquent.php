<?php

namespace App\Repositories;

use App\Entities\Role;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShopManagerRepository;
use App\Entities\ShopManager;
use App\Validators\ShopManagerValidator;

/**
 * Class ShopManagerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopManagerRepositoryEloquent extends BaseRepository implements ShopManagerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShopManager::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        ShopManager::created(function (ShopManager $manager) {
            $role = Role::whereSlug(Role::SHOP_MANAGER)->first(['id']);
            $manager->roles()->attach($role->id);
        });
    }

    public function whereMobile(string $mobile)
    {
        // TODO: Implement whereMobile() method.
        return $this->scopeQuery(function (ShopManager $manager)use ($mobile) {
            return $manager->with(['shop'])->whereMobile($mobile)->limit(1);
        })->get();
    }
}
