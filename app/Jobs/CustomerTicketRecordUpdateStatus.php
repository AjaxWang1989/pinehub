<?php

namespace App\Jobs;

use App\Entities\CustomerTicketCard;
use App\Repositories\CustomerTicketCardRepository;

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
        $this->customerTicketCard = $repository->find($id);
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
        switch ($this->status) {
            case CustomerTicketCard::STATUS_ON : {
                if($this->customerTicketCard->status === CustomerTicketCard::STATUS_OFF) {
                    $this->customerTicketCard->status = CustomerTicketCard::STATUS_ON;
                    $this->customerTicketCard->active = CustomerTicketCard::ACTIVE_ON;
                }
                break;
            }
            case CustomerTicketCard::STATUS_EXPIRE : {
                if ($this->customerTicketCard->status === CustomerTicketCard::STATUS_ON
                    || $this->customerTicketCard->status === CustomerTicketCard::STATUS_EXPIRE) {
                    $this->customerTicketCard->status = CustomerTicketCard::STATUS_EXPIRE;
                }
                break;
            }
        }
        $this->customerTicketCard->save();
    }
}
