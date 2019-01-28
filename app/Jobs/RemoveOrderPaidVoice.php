<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Storage;

class RemoveOrderPaidVoice extends Job
{
    protected $file = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        //
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Storage::delete($this->file);
    }
}
