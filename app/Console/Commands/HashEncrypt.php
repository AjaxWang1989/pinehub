<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashEncrypt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hash:aes {value} {hash}';

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
     */
    public function handle()
    {
        //
        $value = $this->argument('value');
        $hash = $this->argument('hash');

        $md5 = md5($value.config('app.public_key'));
        $check = Hash::check($md5, $hash);
        $result = $check ? 'pass' : 'failure';
        echo "value hash result: {$hash} \n; value md5 result: {$md5} \n; check md5 hash {$result} \n";

    }
}
