<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 11:27
 */

namespace App\Http\Controllers\MiniProgram;
use App\Repositories\CategoryRepository;
use App\Repositories\AppRepository;
use Dingo\Api\Http\Request;
use App\Transformers\Mp\CategoriesTransformer;


class CategoriesController extends Controller
{
    protected  $categoryRepository = null;

    /**
     * CategoriesController constructor.
     * @param CategoryRepository $categoryRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(CategoryRepository $categoryRepository,AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->categoryRepository = $categoryRepository;
    }
    /*
     * 获取预定商城所有分类
     */
//    public function categories(){
//        $item = $this->categoryRepository->all();
//        return $this->response->collection($item,new CategoriesTransformer);
//    }
    /*
     * $param int $id
     */

//    public function categoriesMerchandises(int $id){
//        return '123';
//    }
}