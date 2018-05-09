<?php

namespace App\Http\Controllers\Api;

use App\Entities\Shop;
use App\Http\Response\UpdateResponse;
use App\Repositories\ShopRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\WechatUserRepositoryEloquent;
use App\Transformers\Api\ShopListItemTransformer;
use App\Transformers\Api\UpdateResponseTransformer;
use App\Transformers\ShopsTransformer;
use App\Transformers\UserDetailTransformer;
use App\Utils\GeoHash;
use Carbon\Carbon;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use GeoJson\Geometry\Point;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{

    protected $shopModel = null;

    protected $userModel = null;

    protected  $wechatUserModel = null;

    public function __construct(ShopRepositoryEloquent $shopModel, UserRepositoryEloquent $userModel, WechatUserRepositoryEloquent $wechatUserModel)
    {
        $this->shopModel = $shopModel;
        $this->userModel = $userModel;
        $this->wechatUserModel = $wechatUserModel;
    }

    public function bindMobile(Request $request)
    {
        $sessionKey = $request->input('session_key', null);
        $mobile = $request->input('mobile', null);
        if($mobile === null || $sessionKey === null){
            $this->response()->errorInternal('未填写手机号码');
        }
        $user = $this->userModel->firstOrCreate(['mobile' => $mobile]);
        if(!$user){
            $this->response()->errorInternal("{$mobile}用户不存在");
        }
        $wechatUser = $this->wechatUserModel->findWhere(['session_key' => $sessionKey]) ;
        $wechatUser = $wechatUser && $wechatUser->count() > 0 ? $wechatUser->first() : null;
        if(!$wechatUser){
            $this->response()->errorInternal('小程序未登录');
        }
        if($wechatUser->expireAt->timestamp <= time() ){
            $this->response()->errorInternal('小程序session过期');
        }
        $wechatUser->user_id = $user->id;
        $wechatUser->save();
        return $this->response()->item(new UpdateResponse('手机绑定成功'), new UpdateResponseTransformer());
    }

    //
    public function positionUpdate(Request $request)
    {
        if($request->input('lat', null) === null || $request->input('long', null) === null){
            $this->response()->errorInternal('经纬度未传送');
        }
        $user = $this->user();
        $this->shopModel->scopeQuery(function (Shop $shop) use($user){
            $shop->where('user_id', $user->id);
        });
        $shop = $this->shopModel->first();
        if(!$shop){
            $this->response()->errorInternal('您不是店铺经理无权操作');
        }
        $shop->position = new Point($request->input('lat'), $request->input('long'));
        $attributes['geo_hash'] = (new GeoHash())->encode($request->input('lat'), $request->input('long'));
        $shop->save();
        return $this->response()->item(new UpdateResponse(['message' => '更新成功']), new UpdateResponseTransformer());
    }

    public function getShops(Request $request, $hashLength = 6)
    {
        $lat = $request->input('lat');
        $long = $request->input('long');
        if($lat === null || $long === null){
            $this->response()->errorInternal('为传送经纬度');
        }
        $geoHash = new GeoHash();
        $hash = $geoHash->encode($lat, $long);
        // 决定查询范围，值越大，获取的范围越小
        // 当geohash base32编码长度为8时，精度在19米左右，而当编码长度为9时，精度在2米左右，编码长度需要根据数据情况进行选择。
        $preHash = substr($hash, 0, $hashLength);
        //取出相邻八个区域
        $neighbors = $geoHash->neighbors($preHash);
        array_push($neighbors, $preHash);

        $values = '';
        foreach ($neighbors as $key=>$val) {
            $values .= '\'' . $val . '\'' .',';
        }
        $values = substr($values, 0, -1);
        $this->shopModel->scopeQuery(function (Shop $shop) use($values, $hashLength){
            $shop->whereRaw(" LEFT(`geo_hash`, {$hashLength}) IN ({$values})");
        });
        $shops = $this->shopModel->with('orderItems')->paginate(PAGE_LIMIT);
        return $this->response()->paginator($shops, new ShopListItemTransformer());
    }
}
