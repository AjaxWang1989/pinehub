<?php

namespace App\Http\Controllers\Admin;

use App\Http\Response\JsonResponse;

use Exception;
use App\Http\Requests\CardCreateRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Transformers\CardTransformer;
use App\Transformers\CardItemTransformer;
use App\Repositories\Admin\CardRepository;
use App\Http\Controllers\Controller;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($cards, new CardItemTransformer());
        }

        return view('cards.index', compact('cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CardCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(CardCreateRequest $request)
    {
        $card = $this->repository->create($request->all());

        $response = [
            'message' => 'Card created.',
            'data'    => $card->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($card, new CardTransformer());
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
        $card = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($card, new CardTransformer());
        }

        return view('cards.show', compact('card'));
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
     * @param  CardUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(CardUpdateRequest $request, $id)
    {
       $card = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'Card updated.',
           'data'    => $card->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($card, new CardTransformer());
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
                'message' => 'Card deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Card deleted.');
    }
}
