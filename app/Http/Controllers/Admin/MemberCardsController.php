<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\MemberCardCriteria;
use App\Entities\Card;
use App\Events\SyncMemberCardInfoEvent;
use App\Http\Response\JsonResponse;

use App\Services\AppManager;
use Exception;
use App\Http\Requests\Admin\MemberCardCreateRequest;
use App\Http\Requests\Admin\MemberCardUpdateRequest;
use App\Transformers\MemberCardTransformer;
use App\Transformers\MemberCardItemTransformer;
use App\Repositories\CardRepository as MemberCardRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

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

        if (request()->wantsJson()) {

            return $this->response()->paginator($memberCards, new MemberCardItemTransformer());
        }

        return view('memberCards.index', compact('memberCards'));
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
        $data['status'] = Card::CHECK_ING;
        $data['sync'] = $request->input('sync', false) ? Card::SYNC_NO_NEED : Card::SYNC_ING;
        $data['card_info'] = $request->input('member_info');
        $memberCard = $this->repository->create($data);
        Event::fire(new SyncMemberCardInfoEvent($memberCard));
        $response = [
            'message' => 'MemberCard created.',
            'data'    => $memberCard->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($memberCard, new MemberCardTransformer());
        }

        return redirect()->back()->with('message', $response['message']);
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

        if (request()->wantsJson()) {

            return $this->response()->item($memberCard, new MemberCardTransformer());
        }

        return view('memberCards.show', compact('memberCard'));
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
       $memberCard = $this->repository->update($data, $id);
       Event::fire(new SyncMemberCardInfoEvent($memberCard));
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

        if (request()->wantsJson()) {

            return $this->response(new JsonResponse([
                'message' => 'MemberCard deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'MemberCard deleted.');
    }
}