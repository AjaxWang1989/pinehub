<?php

namespace App\Jobs;

use App\Entities\Advertisement;
use Illuminate\Queue\SerializesModels;

class AdvertisementValidCheck extends Job
{
    use SerializesModels;

    protected $advertisement = null;

    protected $status = null;

    /**
     * Create a new job instance.
     *
     * @param Advertisement $advertisement
     * @param $status
     */
    public function __construct(Advertisement $advertisement, $status)
    {
        $this->advertisement = $advertisement;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $advertisement = $this->advertisement;
        if ($this->advertisement) {
            switch ($this->status) {
                case Advertisement::STATUS_ON:
                    if ($advertisement->status === Advertisement::STATUS_WAIT) {
                        $advertisement->status = Advertisement::STATUS_ON;
                        $advertisement->save();
                    }
                    break;
                case Advertisement::STATUS_EXPIRE:
                    if ($advertisement->status === Advertisement::STATUS_ON) {
                        $advertisement->status = Advertisement::STATUS_EXPIRE;
                        $advertisement->save();
                    }
                    break;
            }
        }
    }
}
