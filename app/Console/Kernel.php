<?php

namespace App\Console;

use App\Console\Commands\JWTGenerateCommand;
use Illuminate\Auth\Console\AuthMakeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Foundation\Console\AppNameCommand;
use Illuminate\Foundation\Console\ChannelMakeCommand;
use Illuminate\Foundation\Console\ConfigCacheCommand;
use Illuminate\Foundation\Console\ConfigClearCommand;
use Illuminate\Foundation\Console\ConsoleMakeCommand;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Foundation\Console\ExceptionMakeCommand;
use Illuminate\Foundation\Console\JobMakeCommand;
use App\Console\Commands\KeyGenerateCommand;
use Illuminate\Foundation\Console\ListenerMakeCommand;
use Illuminate\Foundation\Console\MailMakeCommand;
use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Foundation\Console\PolicyMakeCommand;
use Illuminate\Foundation\Console\ProviderMakeCommand;
use Illuminate\Foundation\Console\RequestMakeCommand;
use Illuminate\Foundation\Console\ResourceMakeCommand;
use Illuminate\Foundation\Console\RuleMakeCommand;
use Illuminate\Foundation\Console\VendorPublishCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        VendorPublishCommand::class,
        ConsoleMakeCommand::class,
        AuthMakeCommand::class,
        ChannelMakeCommand::class,
        ControllerMakeCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        ExceptionMakeCommand::class,
        SeederMakeCommand::class,
        ResourceMakeCommand::class,
        RuleMakeCommand::class,
        RequestMakeCommand::class,
        ProviderMakeCommand::class,
        MiddlewareMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        NotificationMakeCommand::class,
        MailMakeCommand::class,
        KeyGenerateCommand::class,
        AppNameCommand::class,
        ConfigCacheCommand::class,
        ConfigClearCommand::class,
        JWTGenerateCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
