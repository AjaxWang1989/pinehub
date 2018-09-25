<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Http\Requests\Admin\Wechat\ArticleCreateRequest;
use App\Http\Requests\Admin\Wechat\ArticleUpdateRequest;
use App\Http\Requests\Admin\Wechat\ForeverMaterialCreateRequest;
use App\Http\Requests\Admin\Wechat\TemporaryMediaCreateRequest;
use App\Http\Response\JsonResponse;
use Carbon\Carbon;
use Dingo\Api\Http\Response as DingoResponse;
use EasyWeChat\Kernel\Http\StreamResponse;
use EasyWeChat\Kernel\Messages\Article;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Http\Response;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MaterialsController.
 *
 * @package namespace App\Http\Controllers\Admin\Wechat;
 */
class MaterialController extends Controller
{

    /**
     * create new temporary media
     * @param TemporaryMediaCreateRequest $request
     * @return Response|DingoResponse|RedirectResponse
     * @throws
     * */
    public function storeTemporaryMedia(TemporaryMediaCreateRequest $request)
    {
        $field = $request->input('file_field', 'file');
        $mediaId = app('wechat')->uploadMedia($request->input('type'), $request->file($field)->getPath());

        $material = [
            'is_tmp' => true,
            'type' => $request->input('type'),
            'media_id' => $mediaId,
            'expires'  => Carbon::now()->next(3)->timestamp,
        ];

        if($request->wantsJson()) {
            return $this->response($material);
        }

        return redirect()->back()->with('message', '临时素材创建成功');
    }


    public function storeForeverNews(ArticleCreateRequest $request)
    {
        $article =new Article($request->all());
        $mediaId = app('wechat')->uploadArticle($article);
        $attributes['app_id'] = $this->currentOfficialAccount->appId;
        $attributes['type'] = WECHAT_NEWS_MESSAGE;
        $attributes['media_id'] = $mediaId;
        if($request->wantsJson()) {
            return $this->response($attributes);
        }

        return redirect()->back()->with('message', '图文素材创建成功');

    }

    public function uploadForeverMaterial(ForeverMaterialCreateRequest $request, string $type = 'image')
    {
        $field = $request->input('file_field', 'file');
        $url = null;
        $title = $request->input('title', null);
        $description = $request->input('description', null);
        $file = $request->file($field);
        if($file) {
            $fileName = str_random().'.'.$file->getClientOriginalExtension();
            $dir = 'temp';
            $result = $file->move($dir, $fileName);
            if(!$result) {
                if($request->wantsJson()) {
                    return $this->response()->error('上传失败');
                }

                return redirect()->back()->withErrors('message', '上传失败');
            }
            if($type !== WECHAT_IMAGE_MESSAGE) {
                return $this->response(new JsonResponse(['file_path' => "{$dir}/{$fileName}"]));
            }

        }else{
            $result = $request->input('file_path');
        }

        if(!$result) {
            if($request->wantsJson()) {
                return $this->response()->error('缺少文件路径');
            }

            return redirect()->back()->withErrors('message', '缺少文件路径');
        }

        $retData = app('wechat')->uploadMaterial($type, $result, $title, $description);
        unlink($result);
        if($request->wantsJson()) {
            return $this->response(new JsonResponse($retData));
        }

        return redirect()->back()->with('message', '临时素材创建成功');
    }


    public function materialStats(Request $request) {
        $stats = app('wechat')->materialstats();
        if($request->wantsJson()) {
            return $this->response(new JsonResponse($stats));
        }

        return redirect()->back()->with($stats);
    }

    public function materialList(Request $request) {
        $limit = $request->input('limit', PAGE_LIMIT);
        $offset = ($request->input('page', 1) - 1) * $limit;
        $result = app('wechat')->materialList($request->input('type'), $offset, $limit);
        if ($request->wantsJson()) {
            return $this->response(new JsonResponse($result));
        }
        return redirect()->back()->with($result);
    }

    public function materialNewsUpdate(ArticleUpdateRequest $request, string $mediaId)
    {
        $attributes = $request->input('article');
        $index = $request->input('index', 0);
        app('wechat')->updateArticle($mediaId, new Article($attributes), $index);
        if($request->wantsJson()) {
            return $this->response(new JsonResponse(['message' => '更新成功']));
        }

        return redirect()->back()->with('message', '更新成功');
    }

    public function deleteMaterial(Request $request, string $mediaId)
    {
        app('wechat')->deleteMaterial($mediaId);
        if($request->wantsJson()) {
            return $this->response(new JsonResponse(['message' => '删除成功']));
        }

        return redirect()->back()->with('message', '删除成功');
    }

    public function material(Request $request, string $mediaId, string $type = null)
    {
        if($type === null || $type === 'temporary') {
            $result = app('wechat')->material($mediaId, $type === 'temporary');
            if($result instanceof  StreamResponse) {
                return $result;
            }
            if($request->wantsJson()) {
                return $this->response(new JsonResponse($result));
            }

            return redirect()->back()->with($result);
        } else {
            throw new NotFoundHttpException('');
        }
    }

    public function materialView(Request $request)
    {
        $httpClient = new Client();
        $response = $httpClient->get($request->input('material_src'));
        return $response;
    }
}
