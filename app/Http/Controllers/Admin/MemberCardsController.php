<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\MemberCardCriteria;
use App\Criteria\Admin\SearchRequestCriteria;
use App\Events\SyncMemberCardInfoEvent;
use App\Http\Response\JsonResponse;

use Dingo\Api\Http\Response;
use Exception;
use App\Http\Requests\Admin\MemberCardCreateRequest;
use App\Http\Requests\Admin\MemberCardUpdateRequest;
use App\Transformers\MemberCardTransformer;
use App\Transformers\MemberCardItemTransformer;
use App\Repositories\MemberCardInfoRepository;
use App\Http\Controllers\Admin\CardsController as Controller;
use Illuminate\Support\Facades\Event;

/**
 * Class MemberCardsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class MemberCardsController extends Controller
{
    /**
     * @var MemberCardInfoRepository
     */
    protected $repository;


    /**
     * MemberCardsController constructor.
     *
     * @param MemberCardInfoRepository $repository
     */
    public function __construct(MemberCardInfoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(MemberCardCriteria::class);
        $this->repository->pushCriteria(SearchRequestCriteria::class);
        $memberCards = parent::index();
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
        $cardInfo = $request->input('member_card_info');
        if(isset($cardInfo['discount']) && $cardInfo['discount'] !== null) {
            $cardInfo['discount'] = (float)$cardInfo['discount'];
        }
        $request->merge([
            'card_info' => $cardInfo,
            'card_type' => $request->input('member_card_type'),
            'platform' => $request->input('platform', WX_TICKET)
        ]);
        $memberCard = parent::storeCard($request);
        $cardInfo = $memberCard->cardInfo;
        if(isset($cardInfo['background_material_id'])) {
            unset($cardInfo['background_material_id']);
        }
        if($memberCard->wechatAppId && $memberCard->sync)
            Event::fire(new SyncMemberCardInfoEvent($memberCard, $cardInfo,
                app('wechat')->officeAccount()));
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
        $request->merge(['card_info' => $request->input('member_info')]);
       $memberCard =  parent::updateCard($request,$id);
       $data['card_info'] = $request->input('member_info');
       if(isset($data['card_info']['base_info']['date_info']))
           $data['card_info']['base_info']['date_info']['type'] = 1;
       if(isset($data['card_info']['background_material_id'])) {
           unset($data['card_info']['background_material_id']);
       }

       Event::fire(new SyncMemberCardInfoEvent($memberCard, $data['card_info'], app('wechat')->officeAccount()));
        return $this->response()->item($memberCard, new MemberCardTransformer());
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
