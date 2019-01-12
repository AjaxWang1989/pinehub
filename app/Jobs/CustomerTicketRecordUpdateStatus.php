<?php

namespace App\Jobs;

use App\Entities\CustomerTicketCard;
use App\Repositories\CustomerTicketCardRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CustomerTicketRecordUpdateStatus extends Job
{

    /**
     * @var CustomerTicketCard
     * */
    protected $customerTicketCard = null;

    protected $status = null;
    /**
     * Create a new job instance.
     * @param CustomerTicketCardRepository $repository
     * @param int $id
     * @param int $status
     * @return void
     */
    public function __construct(CustomerTicketCardRepository $repository, int $id, int $status)
    {
        //
        try{
            $this->customerTicketCard = $repository->find($id);
        }catch (\Exception $exception) {
            if($exception instanceof ModelNotFoundException) {
                Log::error('customer ticket card not found!');
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
        if ($this->customerTicketCard) {
            switch ($this->status) {
                case CustomerTicketCard::STATUS_ON : {
                    if($this->customerTicketCard->status === CustomerTicketCard::STATUS_OFF) {
                        $this->customerTicketCard->status = CustomerTicketCard::STATUS_ON;
                        $this->customerTicketCard->active = CustomerTicketCard::ACTIVE_ON;
                        $this->customerTicketCard->save();
                    }
                    break;
                }
                case CustomerTicketCard::STATUS_EXPIRE : {
                    if ($this->customerTicketCard->status === CustomerTicketCard::STATUS_ON
                        || $this->customerTicketCard->status === CustomerTicketCard::STATUS_EXPIRE) {
                        $this->customerTicketCard->status = CustomerTicketCard::STATUS_EXPIRE;
                        $this->customerTicketCard->save();
                    }
                    break;
                }
            }
        }
    }
}
