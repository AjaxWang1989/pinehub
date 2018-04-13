<?php

namespace App\Console\Commands;

use Tymon\JWTAuth\Commands\JWTGenerateCommand as Command;

class JWTGenerateCommand extends Command
{
    public function handle()
    {
        //
        $this->fire();
    }
}
