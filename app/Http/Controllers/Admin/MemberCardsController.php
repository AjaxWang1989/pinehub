<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\MemberCardCriteria;
use App\Entities\Card;
use App\Events\SyncMemberCardInfoEvent;
use App\Http\Response\JsonResponse;

use App\Services\AppManager;
use Dingo\Api\Http\Response;
use Exception;
use App\Http\Requests\Admin\MemberCardCreateRequest;
use App\Http\Requests\Admin\MemberCardUpdateRequest;
use App\Transformers\MemberCardTransformer;
use App\Transformers\MemberCardItemTransformer;
use App\Repositories\CardRepository as MemberCardRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

/**
 * Class MemberCardsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class MemberCardsController extends Controller
{
    /**
     * @var MemberCardRepository
     */
    protected $repository;


    /**
     * MemberCardsController constructor.
     *
     * @param MemberCardRepository $repository
     */
    public function __construct(MemberCardRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(MemberCardCriteria::class);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberCards = $this->repository->paginate();
        return $this->response()->paginator($memberCards, new MemberCardItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MemberCardCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(MemberCardCreateRequest $request)
    {
        $appManager = app(AppManager::class);
        $data['card_type'] = Card::MEMBER_CARD;
        $data['app_id'] = $appManager->currentApp->id;
        $data['wechat_app_id'] = $appManager->currentApp->wechatAppId;
        $data['status'] = Card::CHECK_ING;
        $data['sync'] = $request->input('sync', false) ? Card::SYNC_NO_NEED : Card::SYNC_ING;
        $data['card_info'] = $request->input('member_info');
        $memberCard = $this->repository->create($data);
        if(isset($data['card_info']['background_material_id'])) {
            unset($data['card_info']['background_material_id']);
        }
        if($data['wechat_app_id'] && $data['sync'])
            Event::fire(new SyncMemberCardInfoEvent($memberCard, $data['card_info'], app('wechat')->officeAccount()));
        return $this->response()->item($memberCard, new MemberCardTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $memberCard = $this->repository->find($id);
        return $this->response()->item($memberCard, new MemberCardTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $memberCard = $this->repository->find($id);

        return view('memberCards.edit', compact('memberCard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MemberCardUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(MemberCardUpdateRequest $request, $id)
    {
       $data['card_info'] = $request->input('member_info');
       Log::debug('card info', $data);
       $memberCard = $this->repository->find($id);
       tap($memberCard, function (Card $card) use($data) {
           $card->cardInfo = multi_array_merge($card->cardInfo, $data['card_info']);
           $card->save();
       });
       if(isset($data['card_info']['base_info']['date_info']))
           $data['card_info']['base_info']['date_info']['type'] = 1;
       if(isset($data['card_info']['background_material_id'])) {
           unset($data['card_info']['background_material_id']);
       }

       Event::fire(new SyncMemberCardInfoEvent($memberCard, $data['card_info'], app('wechat')->officeAccount()));
       $response = [
           'message' => 'MemberCard updated.',
           'data'    => $memberCard->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($memberCard, new MemberCardTransformer());
       }

       return redirect()->back()->with('message', $response['message']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return $this->response(new JsonResponse(['delete_count' => $deleted]));
    }
}
