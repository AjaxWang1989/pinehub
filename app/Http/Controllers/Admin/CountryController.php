<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CountryRepositoryEloquent;
use App\Transformers\CountriesItemTransformer;
use App\Transformers\CountryDetailTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class CountryController extends Controller
{
    //
    private $countryModel = null;
    public function __construct(CountryRepositoryEloquent $countryRepositoryEloquent)
    {
        $this->countryModel = $countryRepositoryEloquent;
    }

    public function getCountries(Request $request){
        $this->countryModel->pushCriteria(app(RequestCriteria::class));
        $result = $this->countryModel->paginate($request->input('limit',
            PAGE_LIMIT));
        return $this->response()->paginator($result, new CountriesItemTransformer());
    }

    public function getCountryDetail($id){
        $item = $this->countryModel->with(['provinces'])->withCount(['cities', 'provinces', 'counties'])->find($id);
        return $this->response()->item($item, new CountryDetailTransformer());
    }

    public function store(Request $request){
        $item = $this->countryModel->create($request->all(['code', 'name']));
        if($item){
            return $this->response()->item($item, new CountryDetailTransformer());
        }else{
            return $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
