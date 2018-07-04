<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\CustomerRepository;
use App\Services\AppManager;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        $openId = null;
        $accessToken = null;
        $scope = $request->get('scope', USER_AUTH_BASE);

        if($scope === USER_AUTH_BASE) {
            $accessToken = app('wechat')->officialAccountAccessToken();
        }
        if ($accessToken) {
            $openId = $accessToken->openId;
        }
        $customer = app('wechat')->officialAccountUser($openId);
        if ($customer) {
            $openId = $customer->platformOpenId;
        }
        $customer->appId = app(AppManager::class)->currentApp->id;

        $this->customerRepository->updateOrCreate(['platform_open_id' => $customer->openId], $customer->toArray());
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
