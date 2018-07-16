<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Customer;
use App\Repositories\CustomerRepository;
use App\Services\AppManager;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class AliAuthController extends Controller
{
    protected $customerRepository = null;

    public function __construct(CustomerRepository $repository)
    {
        $this->session = app('session');
        $this->customerRepository = $repository;
    }

    //
    public function oauth2(Request $request)
    {
        $token = app('alipay')->getToken();
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $aliAppId = config('ali.payment.app_id');
        $redirect = $request->input('redirect_uri', null);
        $customer = $this->customerRepository->updateOrCreate([
            'app_id' => $appId,
            'platform_app_id' => $aliAppId,
            'type' => Customer::ALIPAY_OPEN_PLATFORM,
            'platform_open_id' => $token['user_id']
        ], [
            'app_id' => $appId,
            'platform_app_id' => $aliAppId,
            'type' => Customer::ALIPAY_OPEN_PLATFORM,
            'platform_open_id' => $token['user_id']
        ]);
        session(['customer' => $customer]);
        if($redirect) {
            if(count(parse_query($redirect)) > 0){
                $append = "&customer_id={$token['user_id']}";
            }else{
                $append = "?customer_id={$token['user_id']}";
            }
            return redirect("{$redirect}{$append}");
        }

        return view('404');
    }
}
