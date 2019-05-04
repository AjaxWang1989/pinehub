<?php

namespace App\Console\Commands;

use App\Entities\Advertisement;
use App\Jobs\AdvertisementValidCheck;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class AdvertisementValidCheckCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advertisement:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Advertisement Check and block invalid advertisements.';

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
        Advertisement::query()->where('status', Advertisement::STATUS_WAIT)
            ->where('begin_at', '<=', Carbon::now())
            ->chunk(100, function (Collection $advertisements) {
                $advertisements->map(function (Advertisement $advertisement) {
                    $job = (new AdvertisementValidCheck($advertisement, Advertisement::STATUS_ON))->delay(1);
                    dispatch($job);
                });
            });

        Advertisement::query()->where('status', Advertisement::STATUS_ON)
            ->where('end_at', '<=', Carbon::now())
            ->chunk(100, function (Collection $advertisements) {
                $advertisements->map(function (Advertisement $advertisement) {
                    $job = (new AdvertisementValidCheck($advertisement, Advertisement::STATUS_EXPIRE))->delay(1);
                    dispatch($job);
                });
            });
    }
}
