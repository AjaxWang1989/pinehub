<?php

namespace App\Providers;

use Illuminate\Queue\QueueManager;
use Illuminate\Queue\QueueServiceProvider as ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{
    protected function registerManager()
    {
        $this->app->singleton('queue', function ($app) {
            // Once we have an instance of the queue manager, we will register the various
            // resolvers for the queue connectors. These connectors are responsible for
            // creating the classes that accept queue configs and instantiate queues.
            return tap(new QueueManager($app), function ($manager) {
                $this->registerConnectors($manager);
            });
        });
    }
}
