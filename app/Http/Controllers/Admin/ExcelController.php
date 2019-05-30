<?php

namespace App\Http\Controllers\Admin;

use App\Excel\GeneratorFactory;
use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ExcelController extends Controller
{
    /**
     * 数据导出
     * @param Request $request
     * @return ExcelController|Application|\Laravel\Lumen\Application|mixed
     */
    public function export(Request $request)
    {
        if (!$request->has('key')) {
            throw new InvalidArgumentException('缺少参数key');
        }
        $key = $request->get('key');

        $generator = GeneratorFactory::getGenerator($key);

        $params = $request->input();
        $searchStr = $request->query('searchJson', null);
        if ($searchStr) {
            $searchJson = is_array($searchStr) ? $searchStr : json_decode(urldecode(base64_decode($searchStr)), true);
            $params = array_merge($params, $searchJson);
        }

        if ($generator) {
            $generator->export($params);
            return $this->response(new JsonResponse(['msg' => '数据导出成功']));
        } else {
            return $this->response(new JsonResponse(['msg' => '无导出数据']));
        }
    }
}