<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-16
 * Time: 下午1:39
 */

namespace App\Http\Controllers\MiniProgram;

use App\Http\Response\UpdateResponse;
use Illuminate\Support\Facades\Redis;

class FormIdController extends Controller
{
    public function collect(string $formId)
    {
        $customer = $this->mpUser();

        Redis::command('zadd', ["formid:{$customer->id}", time(), $formId]);

        $formIds = Redis::command('zrange', ["formid:{$customer->id}", 0, -1]);

        return $this->response(new UpdateResponse(['code' => 200, 'msg' => 'success', 'formIds' => $formIds]));
    }
}