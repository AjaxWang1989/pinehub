<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-16
 * Time: 下午1:39
 */

namespace App\Http\Controllers\MiniProgram;

use Illuminate\Support\Facades\Redis;

class FormIdController extends Controller
{
    public function collect(string $formId)
    {
        $customer = $this->mpUser();

        Redis::command('zadd', ["formid:{$customer->id}", time(), $formId]);
    }
}