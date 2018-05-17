<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as City;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepositoryEloquent;
use App\Transformers\CitiesItemTransformer;
use App\Transformers\CityDetailTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class CityController extends Controller
{
    //
    private $cityModel = null;
    public function __construct(CityRepositoryEloquent $cityRepositoryEloquent )
    {
        $this->cityModel = $cityRepositoryEloquent;
    }

    public function getCities(Request $request, int $countryId = null, int $provinceId =null){
        $this->cityModel->pushCriteria(app(RequestCriteria::class));
        $this->cityModel->scopeQuery(function (City $city)use($countryId, $provinceId){
            if($countryId){
                $city->whereCountryId($countryId);
            }
            if($provinceId){
                $city->whereProvinceId($provinceId);
            }
            return $city;
        });
        $result = $this->cityModel->with(['country', 'province'])->withCount('counties')->paginate($request->input('limit',
            PAGE_LIMIT));
        return $this->response()->paginator($result, new CitiesItemTransformer());
    }

    public function getCityDetail($id){
        $item = $this->cityModel->with(['country', 'province', 'counties'])->withCount(['counties'])->find($id);
        return $this->response()->item($item, new CityDetailTransformer());
    }

    public function store(Request $request){
        $item = $this->cityModel->create($request->all(['code', 'name']));
        if($item){
            return $this->response()->item($item, new CityDetailTransformer());
        }else{
            return $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
