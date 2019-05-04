<?php

namespace App\Console\Commands;

use App\Entities\CustomerTicketCard;
use App\Jobs\CustomerTicketRecordUpdateStatus;
use App\Repositories\CustomerTicketCardRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CustomerTicketRefreshStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:customer_ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $nowDate = Carbon::now();
        $repository = app(CustomerTicketCardRepository::class);
        CustomerTicketCard::whereStatus(CustomerTicketCard::STATUS_OFF)
            ->where('begin_at', '<=', $nowDate)
            ->chunk(100, function (Collection $tickets) use($repository){
                $tickets->map(function (CustomerTicketCard $card) use ($repository){
                    $beginJob = (new CustomerTicketRecordUpdateStatus($repository, $card->id,
                        CustomerTicketCard::STATUS_ON))
                        ->delay(1);
                    dispatch($beginJob);
                });
            });

        CustomerTicketCard::whereIn('status', [CustomerTicketCard::STATUS_OFF, CustomerTicketCard::STATUS_ON])
            ->where('end_at', '<=', $nowDate)
            ->chunk(100, function (Collection $tickets) use($repository){
                $tickets->map(function (CustomerTicketCard $card) use ($repository){
                    $endJob = (new CustomerTicketRecordUpdateStatus($repository, $card->id,
                        CustomerTicketCard::STATUS_EXPIRE))
                        ->delay(1);
                    dispatch($endJob);
                });
            });}
}
