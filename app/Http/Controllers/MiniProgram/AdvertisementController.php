<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-20
 * Time: 下午7:51
 */

namespace App\Http\Controllers\MiniProgram;

use App\Repositories\AdvertisementRepository;
use App\Repositories\AppRepository;
use App\Transformers\Mp\AdvertisementTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * @var AdvertisementRepository
     */
    protected $repository = null;

    public function __construct(Request $request, AppRepository $appRepository, AdvertisementRepository $advertisementRepository)
    {
        parent::__construct($request, $appRepository);
        $this->repository = $advertisementRepository;
    }

    public function getLatestAdvertisement(Request $request)
    {
        $advertisement = $this->repository->getAdvertisements();

        if ($advertisement) {
            return $this->response()->item($advertisement, new AdvertisementTransformer());
        }
        throw new ModelNotFoundException('未找到合适的投放广告');
    }
}