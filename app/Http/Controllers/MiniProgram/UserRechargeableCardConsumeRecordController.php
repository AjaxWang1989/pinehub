<?php
/**
 * UserRechargeableCardConsumeRecordController.php
 * User: katherine
 * Date: 19-5-17 下午5:04
 */

namespace App\Http\Controllers\MiniProgram;

use App\Repositories\AppRepository;
use App\Repositories\UserRechargeableCardConsumeRecordsRepository;
use Dingo\Api\Http\Request;

/**
 * Class UserRechargeableCardConsumeRecordController
 * 用户卡片消费记录
 * @package App\Http\Controllers\MiniProgram
 */
class UserRechargeableCardConsumeRecordController extends Controller
{
    private $repository;

    public function __construct(Request $request, AppRepository $appRepository, UserRechargeableCardConsumeRecordsRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($request, $appRepository);
    }
}