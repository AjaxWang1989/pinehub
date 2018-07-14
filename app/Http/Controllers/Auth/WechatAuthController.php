<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\CustomerRepository;
use App\Services\AppManager;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class WechatAuthController extends Controller
{
    //
    protected $customerRepository = null;
    public function __construct(CustomerRepository $repository)
    {
        $this->customerRepository = $repository;
        $this->session = app('session');
    }

    public function serve()
    {

    }

    public function oauth2(Request $request)
    {
        //$openId = null;
        $accessToken = app('wechat')->officeAccount()->oauth->getAccessToken($request->input('code'));
        $openId = $accessToken['openid'];
        //dd($accessToken);
        $customer = app('wechat')->officialAccountUser($openId);
        if ($customer) {
            $openId = $customer->platformOpenId;
        }
//        app('session')->put('customer', $customer);
        $customer->appId = app(AppManager::class)->currentApp->id;

        $customer = $this->customerRepository->updateOrCreate([
            'app_id' => $customer->appId,
            'platform_app_id' => $customer->platformAppId,
            'platform_open_id' => $customer->platformOpenId
        ], $customer->toArray());
        session(['customer' => $customer]);
        $redirect = $request->input('redirect_uri', null);
        if($redirect) {
            if(count(parse_query($redirect)) > 0){
                $append = "&open_id={$openId}";
            }else{
                $append = "?open_id={$openId}";
            }
            return redirect("{$redirect}{$append}");
        }
        return null;
    }

    public function miniProgramAuth()
    {

    }
}
