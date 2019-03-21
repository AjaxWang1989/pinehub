<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/7/3
 * Time: 上午10:03
 */

namespace App\Repositories\Traits;


trait Destruct
{
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->model = null;
        $this->app = null;
        $this->criteria = null;
        $this->scopeQuery = null;
        $this->validator = null;
        $this->rules = null;
        $this->fieldSearchable = null;
    }
}