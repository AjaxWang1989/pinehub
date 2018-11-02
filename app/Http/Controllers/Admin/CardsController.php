<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\Card;
use App\Entities\MemberCard;
use App\Entities\Ticket;
use App\Events\SyncTicketCardInfoEvent;
use App\Http\Requests\Admin\MemberCardCreateRequest;
use App\Http\Requests\Admin\MemberCardUpdateRequest;
use App\Http\Requests\Admin\TicketCreateRequest;
use App\Http\Response\JsonResponse;

use App\Services\AppManager;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Exception;
use App\Http\Requests\Admin\TicketUpdateRequest;
use App\Transformers\TicketTransformer;
use App\Transformers\TicketItemTransformer;
use App\Repositories\CardRepository;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;

/**
 * Class CardsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class CardsController extends Controller
{
    /**
     * @var CardRepository
     */
    protected $repository;


    /**
     * CardsController constructor.
     *
     * @param CardRepository $repository
     */
    public function __construct(CardRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function colors()
    {
        return $this->wechat->officeAccount()->card->colors();
    }

    public function  categories()
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
        $cards = $this->repository
            ->paginate();
        return $cards;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request|TicketCreateRequest|MemberCardCreateRequest $request
     *
     * @return mixed|Card|Ticket|MemberCard
     *
     */
    public function storeCard(Request $request)
    {
        $appManager = app(AppManager::class);
        $data['card_info'] = $request->input('ticket_info');
        $data['app_id'] = $appManager->currentApp->id;
        $data['wechat_app_id'] = $appManager->currentApp->wechatAppId;
        $data['begin_at'] = $request->input('begin_at');
        $data['end_at'] = $request->input('end_at');
        $data['card_type'] = $request->input('ticket_type');
        return $this->repository->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Card|Ticket|MemberCard
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
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function updateCard(Request $request, $id)
    {
       $data['card_type'] = $request->input('ticket_type');
       $data['card_info'] = $request->input('ticket_info');
       $data['begin_at'] = $request->input('begin_at', null);
       $data['end_at'] = $request->input('end_at', null);
       $card = $this->repository->find($id);
       tap($card, function (Card $card) use($data){
          $card->cardInfo = multi_array_merge($card->cardInfo, $data['card_info']);
          $card->cardType = $data['card_type'];
          $card->beginAt  = $data['begin_at'];
          $card->endAt    = $data['end_at'];
          $card->save();
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
