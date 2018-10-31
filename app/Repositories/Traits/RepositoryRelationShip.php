<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/10/31
 * Time: 下午3:11
 */

namespace App\Repositories\Traits;


trait RepositoryRelationShip
{
    /**
     * Add subselect queries to sum the relations.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function withSum($relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }
}