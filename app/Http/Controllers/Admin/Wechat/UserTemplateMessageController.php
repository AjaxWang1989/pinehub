<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 上午11:46
 */

namespace App\Http\Controllers\Admin\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Wechat\UserTemplateMessageCreateRequest;
use App\Http\Requests\Admin\Wechat\UserTemplateMessageUpdateRequest;
use App\Repositories\UserTemplateMessageRepository;
use App\Services\AppManager;
use App\Transformers\UserTemplateMessageTransformer;
use Illuminate\Support\Facades\Redis;

class UserTemplateMessageController extends Controller
{
    private $userTemplateMessageRepository;

    public function __construct(UserTemplateMessageRepository $userTemplateMessageRepository)
    {
        parent::__construct();
        $this->userTemplateMessageRepository = $userTemplateMessageRepository;
    }

    public function index(string $wxType)
    {
        $paginator = $this->userTemplateMessageRepository->getTemplates($wxType);

        return $this->response->paginator($paginator, new UserTemplateMessageTransformer());
    }

    // 某一微信模板下的自定义模板消息
    public function templates(int $parentTemplateId)
    {
        $paginator = $this->userTemplateMessageRepository->getTemplatesViaParent($parentTemplateId);

        return $this->response()->paginator($paginator, new UserTemplateMessageTransformer());
    }

    public function create(UserTemplateMessageCreateRequest $request)
    {
        $data['wx_app_id'] = app(AppManager::class)->miniProgram()->appId;
        $data['template_id'] = $request->input('template_id');
        $data['content'] = $request->input('content');

        $userTemplateMessage = $this->userTemplateMessageRepository->create($data);

        return $this->response()->item($userTemplateMessage, new UserTemplateMessageTransformer());
    }

    public function update(UserTemplateMessageUpdateRequest $request, $id)
    {
        $userTemplateMessage = $this->userTemplateMessageRepository->find($id);

        $data = $request->all();

        $userTemplateMessage->update($data);

        return $this->response()->item($userTemplateMessage, new UserTemplateMessageTransformer());
    }

    public function delete($id)
    {
        $this->userTemplateMessageRepository->delete($id);

        return $this->response()->noContent();
    }

    public function show()
    {

    }
}