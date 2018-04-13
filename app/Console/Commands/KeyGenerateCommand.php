<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\KeyGenerateCommand as Command;

class KeyGenerateCommand extends Command
{
    protected function writeNewEnvironmentFileWith($key)
    {
        $path = base_path('.env');
        file_put_contents($path, preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key,
            file_get_contents($path)
        ));
    }
}
