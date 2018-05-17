<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as County;
use App\Http\Controllers\Controller;
use App\Repositories\CountyRepositoryEloquent;
use App\Transformers\CountiesItemTransformer;
use App\Transformers\CountyDetailTransformer;
use Prettus\Repository\Criteria\RequestCriteria;
use Dingo\Api\Http\Request;

class CountyController extends Controller
{
    //
    private $countyModel = null;
    public function __construct(CountyRepositoryEloquent $countyRepositoryEloquent )
    {
        $this->countyModel = $countyRepositoryEloquent;
    }

    public function getCounties(Request $request, int $countryId = null, int $provinceId = null, int $cityId = null){
        $this->countyModel->pushCriteria(app(RequestCriteria::class));
        $this->countyModel->scopeQuery(function (County $county)use($countryId, $provinceId, $cityId){
            if($countryId){
                $county->whereCountryId($countryId);
            }
            if($provinceId){
                $county->whereProvinceId($provinceId);
            }
            if($cityId){
                $county->whereCityId($cityId);
            }
            return $county;
        });
        $result = $this->countyModel->with(['country', 'province', 'city'])->paginate($request->input('limit',
            PAGE_LIMIT));
        return $this->response()->paginator($result, new CountiesItemTransformer());
    }

    public function getCountyDetail($id){
        $item = $this->countyModel->with(['country', 'province', 'city'])->find($id);
        return $this->response()->item($item, new CountyDetailTransformer());
    }

    public function store(Request $request){
        $item = $this->countyModel->create($request->all(['code', 'name']));
        if($item){
            return $this->response()->item($item, new CountyDetailTransformer());
        }else{
            return $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
