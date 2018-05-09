<?php

namespace App\Console;

use App\Console\Commands\Console\TestMakeCommand;
use App\Console\Commands\JWTGenerateCommand;
use App\Console\Commands\ModelsCommand;
use Illuminate\Auth\Console\AuthMakeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use App\Console\Commands\Console\AppNameCommand;
use App\Console\Commands\Console\ChannelMakeCommand;
use App\Console\Commands\Console\ConfigCacheCommand;
use App\Console\Commands\Console\ConfigClearCommand;
use App\Console\Commands\Console\ConsoleMakeCommand;
use App\Console\Commands\Console\EventMakeCommand;
use App\Console\Commands\Console\ExceptionMakeCommand;
use App\Console\Commands\Console\JobMakeCommand;
use App\Console\Commands\Console\KeyGenerateCommand;
use App\Console\Commands\Console\ListenerMakeCommand;
use App\Console\Commands\Console\MailMakeCommand;
use App\Console\Commands\Console\NotificationMakeCommand;
use App\Console\Commands\Console\PolicyMakeCommand;
use App\Console\Commands\Console\ProviderMakeCommand;
use App\Console\Commands\Console\RequestMakeCommand;
use App\Console\Commands\Console\ResourceMakeCommand;
use App\Console\Commands\Console\RuleMakeCommand;
use App\Console\Commands\Console\VendorPublishCommand;
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
        JWTGenerateCommand::class,
        ModelsCommand::class,
        TestMakeCommand::class
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
