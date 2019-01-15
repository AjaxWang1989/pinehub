<?php

namespace App\Jobs;

use App\Entities\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TicketUpdateStatus extends Job
{

    /**
     * @var Ticket
     * */
    protected $ticket = null;

    protected $status = null;
    /**
     * Create a new job instance.
     * @param TicketRepository $repository
     * @param int $id
     * @param int $status
     * @return void
     */
    public function __construct(TicketRepository $repository, int $id, int $status)
    {
        //
        try {
            $this->ticket = $repository->find($id);
        }catch (\Exception $exception) {
            if ($exception instanceof ModelNotFoundException) {
                Log::error('ticket model not found!');
            }
        }
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if ($this->ticket) {
            $nowDate = Carbon::now();
            switch ($this->status) {
                case Ticket::STATUS_ON : {
                    if ($this->ticket->status === Ticket::STATUS_OFF
                        && $nowDate->diffInRealSeconds($this->ticket->beginAt, false) < 1
                        && $nowDate->diffInRealSeconds($this->ticket->endAt, false) > 1) {
                        $this->ticket->status = Ticket::STATUS_ON;
                    }
                    break;
                }
                case Ticket::STATUS_EXPIRE: {
                    if ($this->ticket->status === Ticket::STATUS_ON
                        && $nowDate->diffInRealSeconds($this->ticket->endAt, false) < 1) {
                        $this->ticket->status = Ticket::STATUS_OFF;
                    }
                    break;
                }
            }
            $this->ticket->save();
        }

    }
}
