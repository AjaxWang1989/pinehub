<?php

namespace App\Http\Controllers\Admin;

use App\Http\Response\JsonResponse;

use App\Repositories\UserRepository;
use App\Services\AppManager;
use Dingo\Api\Http\Request;
use Exception;
use App\Http\Requests\Admin\ShopCreateRequest;
use App\Http\Requests\Admin\ShopUpdateRequest;
use App\Transformers\ShopTransformer;
use App\Transformers\ShopItemTransformer;
use App\Repositories\ShopRepository;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Controller;

/**
 * Class ShopsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class ShopsController extends Controller
{
    /**
     * @var ShopRepository
     */
    protected $repository;

    protected $userRepository;


    /**
     * ShopsController constructor.
     *
     * @param ShopRepository $repository
     * @param UserRepository $userRepository
     */
    public function __construct(ShopRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($shops, new ShopItemTransformer());
        }

        return view('shops.index', compact('shops'));
    }

    /**
     * 获取店铺老板/经理人的用户信息
     * @param string $mobile
     * @param string $name
     * @return User
     * @throws
     * */
    protected function getOwner(string $mobile, string $name)
    {
        $user = $this->userRepository->findWhere(['mobile' => $mobile])->first();
        if(!$user){
            $user = $this->userRepository->create([
                'user_name' => $mobile,
                'password' => password($mobile),
                'real_name' => $name,
                'mobile' => $mobile
            ]);
        }
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ShopCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(ShopCreateRequest $request)
    {
        $data = $request->only(['name', 'country_id', 'province_id', 'city_id', 'county_id', 'address', 'description', 'status']);
        $appManager = app(AppManager::class);
        $data['app_id'] = $appManager->currentApp->id;
        $data['user_id'] = $this->getOwner($request->input('manager_mobile'), $request->input('manager_name'))->id;
        if($request->input('lat', null) && $request->input('lng', null)){
            $data['position'] = new PointType($request->input('lat'), $request->input('lng'));
            $data['geo_hash'] = (new GeoHash())->encode($request->input('lat'), $request->input('lng'));
        }
        $data['wechat_app_id'] = $appManager->officialAccount->appId;
        $data['ali_app_id'] = $appManager->aliPayOpenPlatform->config['app_id'];

        $shop = $this->repository->create($data);
        $response = [
            'message' => 'Shop created.',
            'data'    => $shop->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($shop, new ShopTransformer());
        }

        return redirect()->back()->with('message', $response['message']);
    }

    public function paymentQRCode(Request $request, int $id)
    {
        $shop = $this->repository->find($id);
        $appManager = app(AppManager::class);
        $size = $request->input('size', null);
        if($shop && $appManager->currentApp && $size !== null && $size > 0) {
           $url = webUriGenerator('/payment/aggregate.html', env('WEB_PAYMENT_PREFIX'), env('WEB_DOMAIN'));
           $url .= "?shop_id={$shop->id}";
           $url .= "&selected_appid={$appManager->currentApp->id}";
           $qrCode = QrCode::format('png')->size($size)->generate($url);
            if($request->wantsJson()) {
                $qrCode = base64_encode($qrCode);
                return $this->response(new JsonResponse([
                    'qr_code' => 'data:image/png;base64, '.$qrCode
                ]));
            }else{
                return Response::create($qrCode)->header('Content-Type', 'image/png');
            }
           return $this->response(new JsonResponse([
               'qr_code' => 'data:image/png;base64, '.$qrCode
           ]));
        }else{
            return $this->response()->error('参数错误');
        }
    }

    public function officialAccountQRCode(Request $request, int $id)
    {
        $shop = $this->repository->find($id);
        $appManager = app(AppManager::class);
        $size = $request->input('size', null);
        if($shop && $appManager->currentApp && $size !== null && $size > 0) {
            $data = "\{
                'app_id': {$shop->appId},
                'shop_id': {$shop->id}
            \}";
            $qrCode = app('wechat')->openPlatform()->officialAccount($shop->wechatAppId)->qrcode->url(base64_encode($data));
            if($request->wantsJson()) {
                $qrCode = base64_encode($qrCode);
                return $this->response(new JsonResponse([
                    'qr_code' => 'data:image/png;base64, '.$qrCode
                ]));
            }else{
                return Response::create($qrCode)->header('Content-Type', 'image/png');
            }

        }else{
            return $this->response()->error('参数错误');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($shop, new ShopTransformer());
        }

        return view('shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = $this->repository->find($id);

        return view('shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ShopUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(ShopUpdateRequest $request, $id)
    {
        $data = $request->only(['name', 'country_id', 'province_id', 'city_id', 'county_id', 'address', 'description', 'status', 'user_id']);
        $appManager = app(AppManager::class);
        $data['app_id'] = $appManager->currentApp->id;
        if(isset($data['user_id']) && $data['user_id'] && $request->input('manager_mobile', null) && $request->input('manager_name', null))
            $data['user_id'] = $this->getOwner($request->input('manager_mobile'), $request->input('manager_name'))->id;
        if($request->input('lat', null) && $request->input('lng', null)){
            $data['position'] = new PointType($request->input('lat'), $request->input('lng'));
            $data['geo_hash'] = (new GeoHash())->encode($request->input('lat'), $request->input('lng'));
        }

       $shop = $this->repository->update($data, $id);

       $response = [
           'message' => 'Shop updated.',
           'data'    => $shop->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($shop, new ShopTransformer());
       }

       return redirect()->back()->with('message', $response['message']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return $this->response(new JsonResponse([
                'message' => 'Shop deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Shop deleted.');
    }
}
