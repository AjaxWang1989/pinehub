<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 15:46
 */

namespace App\Http\Controllers\MiniProgram;

use App\Repositories\ShopRepository;
use App\Repositories\AppRepository;
use App\Transformers\Mp\ShopPositionTransformer;
use Dingo\Api\Http\Request;

class ShopsController extends Controller
{
    protected  $shopRepository = null;

    /**
     * ShopsController constructor.
     * @param ShopRepository $shopRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShopRepository $shopRepository, AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->shopRepository = $shopRepository;
    }

    /**
     * 获取今日下单店铺
     * @param string $id
     * @return \Dingo\Api\Http\Response
     */
    public function nearestStore(Request $request){
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $item = $this->shopRepository->nearest($lng,$lat);
        return $this->response()->item($item, new ShopPositionTransformer());
    }

    /**
     *获取附近店铺
     * @return \Dingo\Api\Http\Response
     */
    public function nearbyStores(Request $request){
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $item = $this->shopRepository->nearBy($lng,$lat);
        return $this->response()->paginator($item, new ShopPositionTransformer());
    }
}