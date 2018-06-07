<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Http\Response\CreateResponse;
use App\Repositories\WechatConfigRepositoryEloquent;
use App\Transformers\WechatConfigTransformer;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;

class ConfigController extends Controller
{
    //
    protected $wechatConfig = null;

    public function __construct(WechatConfigRepositoryEloquent $wechatConfig)
    {
        $this->wechatConfig = $wechatConfig;
    }

    /**
     *创建保存微信公众号或者小程序配置信息
     * @post("/wechat/config")
     * @Request({"app_id":"wx2a82ea92e7b9c1a2", "app_secret": "2a82ea92e7b9c1a22a82ea92e7b9c1a2", ""}, headers={})
     * @Versions({"v0.0.1"})
     * @Response(200, body={"status_code": "200", "data":{
     *
     *  }})
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function store(Request $request)
    {
        $config = $this->wechatConfig->create($request->all());
        if(!$config) {
            return $this->response()->error('微信公众号或者小程序配置信息保存失败！');
        }
        return $this->response(new CreateResponse('微信公众号或者小程序配置信息保存成功！'));
    }

    /**
     *获取微信公众号与小程序配置信息列表
     * @GET("/wechat/configs")
     * @Request({""}, headers={})
     * @Versions({"v0.0.1"})
     * @Response(200, body={"status_code": "200", "data":{
     *
     *  }})
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function getWechatConfigList(Request $request)
    {
        $paginate = $this->wechatConfig->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($paginate, new WechatConfigTransformer());
    }

    public function getWechatConfigDetail($id)
    {
        $detail = $this->wechatConfig->find($id);
        if(!$detail) {
            return $this->response()->error('微信公众号或者小程序不存在！');
        }
        return $this->response()->item($detail, new WechatConfigTransformer());
    }
}
