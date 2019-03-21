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

    public function index(Request $request)
    {
        $advertisements = $this->repository->getAdvertisements();

        return $this->response()->paginator($advertisements, new AdvertisementTransformer());
    }
}