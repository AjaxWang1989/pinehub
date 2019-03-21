<?php

namespace App\Console\Commands;

use App\Entities\Ticket;
use App\Jobs\TicketUpdateStatus;
use App\Repositories\TicketRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class TicketRefreshStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:ticket';

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
        $repository = app(TicketRepository::class);
        Ticket::whereStatus(Ticket::STATUS_OFF)
            ->where('begin_at', '<=', $nowDate)
            ->chunk(100, function (Collection $tickets) use ($repository){
                $tickets->map(function (Ticket $ticket) use ($repository){
                    $beginJob = (new TicketUpdateStatus($repository, $ticket->id, Ticket::STATUS_ON))
                        ->delay(1);
                    dispatch($beginJob);
                });
            });

        Ticket::whereIn('status', [Ticket::STATUS_OFF, Ticket::STATUS_ON])
            ->where('end_at', '<=', $nowDate)
            ->chunk(100, function (Collection $tickets) use ($repository){
                $tickets->map(function (Ticket $ticket) use ($repository){
                    $endJob = (new TicketUpdateStatus($repository, $ticket->id, Ticket::STATUS_EXPIRE))
                        ->delay(1);
                    dispatch($endJob);
                });
            });
    }
}
