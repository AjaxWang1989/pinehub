<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\Card;
use App\Entities\MemberCardInfo;
use App\Entities\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberCardCreateRequest;
use App\Http\Requests\Admin\MemberCardUpdateRequest;
use App\Http\Requests\Admin\TicketCreateRequest;
use App\Http\Requests\Admin\TicketUpdateRequest;
use App\Http\Response\JsonResponse;
use App\Repositories\CardRepository;
use App\Repositories\MemberCardInfoRepository;
use App\Repositories\TicketRepository;
use App\Services\AppManager;
use Dingo\Api\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CardsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class CardsController extends Controller
{
    /**
     * @var TicketRepository|MemberCardInfoRepository
     */
    protected $repository;


    /**
     * CardsController constructor.
     *
     * @param CardRepository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function colors()
    {
        return $this->wechat->officeAccount()->card->colors();
    }

    public function categories()
    {
        return $this->wechat->officeAccount()->card->categories();
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|Collection
     */
    public function index()
    {
        $this->repository->pushCriteria(SearchRequestCriteria::class);
        $cards = $this->repository->orderBy('created_at', 'desc')->paginate();
        return $cards;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request|TicketCreateRequest|MemberCardCreateRequest $request
     *
     * @return mixed|Card|Ticket|MemberCardInfo
     *
     */
    public function storeCard($request)
    {
        $appManager = app(AppManager::class);
        $data['card_info'] = $request->input('card_info');
        $data['app_id'] = $appManager->currentApp->id;
        //$data['card_id'] = str_random(32);
        $data['wechat_app_id'] = $appManager->currentApp->wechatAppId;
        $data['card_type'] = $request->input('card_type');
        $data['sync'] = $request->input('sync');
        $data['issue_count'] = $request->input('issue_count', 0);
        $data['platform'] = $request->input('platform');
        $data['begin_at'] = $request->input('begin_at', null);
        $data['end_at'] = $request->input('end_at', null);
        $data['status'] = Card::STATUS_OFF;

        /** @var Ticket $ticket */
        $ticket = $this->repository->create($data);

        if ($request->input('conditions.put.scenarios.type') === SCENARIO_ALL) {
            $put_show = SCENARIO_ALL_NUM;
        } else {
            $put_show = $request->input('conditions.put.scenarios.selected_scenarios', null);
        }
        if ($request->input('conditions.use.scenarios.type') === SCENARIO_ALL) {
            $use_show = SCENARIO_ALL_NUM;
        } else {
            $use_show = $request->input('conditions.use.scenarios.selected_scenarios', null);
        }

        if ($request->input('conditions.put.range.type') == CUSTOMER_RANGE_ALL) {
            $put_tags = null;
        } else {
            $put_tags = $request->input('conditions.put.range.selected_user_tags', null);
        }

        $put_loop_type = $request->input('conditions.put.loop.type', TICKET_LOOP_TYPE_NO_CONDITION);

        $ticket->putCondition()->create([
            'valid_obj' => [
                'customers' => [
                    'sex' => $request->input('conditions.put.sex', 'ALL'),
                    'tags' => $put_tags
                ]
            ],
            'show' => (array)$put_show,
            'pre_payment_amount' => $put_loop_type === TICKET_LOOP_TYPE_SINGLE ? $request->input('conditions.put.loop.single_amount', 0) : 0,
            'loop' => $put_loop_type === TICKET_LOOP_TYPE_LOOP ? $request->input('conditions.put.loop.days', 0) : 0,
            'loop_order_num' => $put_loop_type === TICKET_LOOP_TYPE_LOOP ? $request->input('conditions.put.loop.count', 0) : 0,
            'loop_order_amount' => $put_loop_type === TICKET_LOOP_TYPE_LOOP ? $request->input('conditions.put.loop.total_amount', 0) : 0,
            'type' => TICKET_CONDITION_TYPE_PUT
        ]);

        $ticket->useCondition()->create([
            'show' => (array)$use_show,
            'type' => TICKET_CONDITION_TYPE_USE
        ]);

        return $ticket;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Card|Ticket|MemberCardInfo
     */
    public function show($id)
    {
        $card = $this->repository->find($id);
        return $card;
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
        $card = $this->repository->find($id);

        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TicketUpdateRequest|Request|MemberCardUpdateRequest $request
     * @param  string $id
     *
     * @return Card|Ticket|MemberCardInfo
     *
     * @throws Exception
     */
    public function updateCard($request, $id)
    {
        $data = $request->all();

        $card = $this->repository->find($id);
        tap($card, function (Card $card) use ($data) {
            if (isset($data['card_info']) && $data['card_info']) {
                $data['card_info'] = multi_array_merge($card->cardInfo, $data['card_info']);
            }
            $card->update($data);
        });
        return $card;
    }


    public function qrCode(int $id)
    {
        $ticket = $this->repository->find($id);

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

        if (request()->wantsJson()) {

            return $this->response(new JsonResponse([
                'message' => 'Card deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Card deleted.');
    }
}
