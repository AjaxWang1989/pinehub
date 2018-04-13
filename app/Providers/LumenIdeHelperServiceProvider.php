<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider as ServiceProvider;

class LumenIdeHelperServiceProvider extends ServiceProvider
{
    protected function mergeConfigFrom($path, $key)
    {
        $configs = config('ide-helper');
        app('config')->set('ide-helper', array_merge(require $path, $configs??[]));
    }
}
