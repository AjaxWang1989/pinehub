<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\CustomerRepository;
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
        $redirect = $request->input('redirect_uri', null);
        $customer = $this->customerRepository->updateOrCreate(['platform_open_id' => $token['user_id']], [
            'app_id' => $request->input('selected_appid', null),
            'platform_app_id' => config('ali.payment.app_id'),
            'type' => 'ALIPAY_OPEN_PLATFORM',
            'platform_open_id' => $token['user_id']
        ]);
        session(['customer' => $customer]);
        if($redirect) {
            if(count(parse_query($redirect)) > 0){
                $append = "&buyer_id={$token['user_id']}";
            }else{
                $append = "?buyer_id={$token['user_id']}";
            }
            return redirect("{$redirect}{$append}");
        }

        return view('404');
    }
}
