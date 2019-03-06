<?php

namespace App\Providers;

use App\Ali\Oauth\AliOauthServiceProvider;
use App\Entities\User;
use App\Entities\Role;
use App\Http\Middleware\Cross;
use App\Providers\LumenIdeHelperServiceProvider as IdeHelperServiceProvider;
use App\Services\AppManager;
use App\Services\FileService;
use App\Services\UIDGeneratorService;
use Dingo\Api\Http\Request;
use Hhxsv5\LaravelS\Illuminate\LaravelSServiceProvider;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\Looping;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\{
    Broadcast, DB, Log, Validator
};
use Illuminate\Support\ServiceProvider;
use Jacobcyl\AliOSS\AliOssServiceProvider;
use Laravel\Lumen\Application;
use Mpociot\ApiDoc\ApiDocGeneratorServiceProvider;
use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Overtrue\LaravelWeChat\ServiceProvider as WechatLumenServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if($this->app->environment() !== "production" && !$this->app->runningInConsole()){
            DB::listen(function (QueryExecuted $event){
                Log::debug($event->time.':'.$event->sql, $event->bindings);
            });
        }

        $this->app->singleton('file',function (Application $app) {
            return $app->make(FileService::class);
        });

        $this->app->bind(Factory::class, function () {
            return $this->app['filesystem'];
        });

        Validator::extend('not_exists', function($attribute, $value, $parameters)
        {
            return DB::table($parameters[0])
                    ->where($parameters[1], '=', $value)
                    ->count()<1;
        });

        Validator::extend('file_exist', function ($attribute, $value, $parameters) {
            return file_exists($value);
        });

        Validator::extend('mobile', function ($attribute, $value, $parameters) {
            return preg_match(MOBILE_PATTERN, $value);
        });

        Validator::extend('verify_code', function ($attribute, $value, $parameters) {
            return preg_match('/^\d{6}$/', $value);
        });

        Validator::extend('roles', function ($attribute, $value, $parameters) {
            $user = User::with('roles')->where($attribute, $value)->first();
            $roles = [];
            foreach ($parameters as $key => $value) {
                if(property_exists(Role::class, $value)) {
                    $role = eval(Role::class.$value);
                    $roles[] = $role;
                } else {
                    return false;
                }
            }

            return $user->roles->whereIn('slug', $roles)->count() > 0;
        });
        app('queue')->before(function (JobProcessing $jobProcessing) {
//            Log::info('job queue processing', $jobProcessing->job->payload());
        });

        app('queue')->after(function (JobProcessed $jobProcessed) {
            Log::info('job queue processed!', $jobProcessed->job->payload());
        });

        app('queue')->looping(function (Looping $looping) {
//            Log::info('job queue looping '.$looping->queue);
        });

        app('queue')->exceptionOccurred(function (JobExceptionOccurred $exceptionOccurred) {
            Log::info('job queue exception Occurred', $exceptionOccurred->job->payload());
        });

        app('queue')->failing(function (JobFailed $jobFailed) {
            Log::info('job failed', $jobFailed->job->payload());
        });

        app('queue')->stopping(function () {
            Log::info('queue stopping');
        });

    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Request::class, function (){
            return Request::capture();
        });
        laravelToLumen($this->app)->middleware(Cross::class);
        $this->app->register(WechatLumenServiceProvider::class);
        $this->app->register(AliOauthServiceProvider::class);
        $this->app->register(FilesystemServiceProvider::class);
        $this->app->register(AliOssServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(QrCodeServiceProvider::class);
        $this->app->register(\Curder\LaravelAliyunSms\ServiceProvider::class);
        $this->app->singleton('uid.generator', function () {
            return new UIDGeneratorService();
        });
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(ApiDocGeneratorServiceProvider::class);
        }
        $this->app->singleton(AppManager::class, function (Application $app) {
            return new AppManager($app);
        });
        $this->app->register(LaravelSServiceProvider::class);
        $this->app->register(QueueServiceProvider::class);

        if($this->app->runningInConsole()) {
//            $this->app->register(\EchoServer\BroadcastServerServiceProvider::class);
        }
    }
}
