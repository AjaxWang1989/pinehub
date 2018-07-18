<?php

namespace App\Repositories;

use App\Criteria\Admin\CategoryCriteria;
use App\Services\AppManager;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Category;
use App\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(CategoryCriteria::class));
        Category::creating(function (Category $category) {
            $category->appId = app(AppManager::class)->currentApp->id;
            return $category;
        });
    }
    
}
