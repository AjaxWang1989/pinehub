<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as Province;
use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepositoryEloquent;
use App\Transformers\ProvinceDetailTransformer;
use App\Transformers\ProvincesItemTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class ProvinceController extends Controller
{
    //
    private $provinceModel = null;
    public function __construct(ProvinceRepositoryEloquent $provinceRepositoryEloquent )
    {
        $this->provinceModel = $provinceRepositoryEloquent;
    }

    public function getProvinces(Request $request, int $countryId = null){
        $this->provinceModel->pushCriteria(app(RequestCriteria::class));
        $this->provinceModel->scopeQuery(function (Province $province) use ($countryId){
            return $countryId ? $province->whereCountryId($countryId) : $province;
        });
        $result = $this->provinceModel->with(['country'])->withCount(['cities', 'counties'])->paginate($request->input('limit',
            PAGE_LIMIT));
        return $this->response()->paginator($result, new ProvincesItemTransformer());
    }

    public function getProvinceDetail($id){
        $item = $this->provinceModel->with(['country', 'cities'])->withCount(['cities', 'counties'])->find($id);
        return $this->response()->item($item, new ProvinceDetailTransformer());
    }

    public function store(Request $request){
        $item = $this->provinceModel->create($request->all(['code', 'name']));
        if($item){
            return $this->response()->item($item, new ProvinceDetailTransformer());
        }else{
            return $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
