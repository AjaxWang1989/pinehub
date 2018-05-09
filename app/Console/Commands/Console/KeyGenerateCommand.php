<?php

namespace App\Console\Commands\Console;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Console\ConfirmableTrait;

class KeyGenerateCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:generate
                    {--show : Display the key instead of modifying files}
                    {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->generateRandomKey();
        $publicKey = $this->generateRandomKey();
        $privateKey = $this->generateRandomKey();

        if ($this->option('show')) {
            $this->line('<comment>'.$key.'</comment>');
            $this->line('<comment>'.$publicKey.'</comment>');
            $this->line('<comment>'.$privateKey.'</comment>');
        }

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        if (! $this->setKeyInEnvironmentFile($key, $publicKey, $privateKey)) {
            return;
        }

        laravelToLumen($this->laravel)['config']['app.key'] = $key;
        laravelToLumen($this->laravel)['config']['app.public_key'] = $publicKey;
        laravelToLumen($this->laravel)['config']['app.private_key'] = $privateKey;
        $this->info("Application key [$key] set successfully.");
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey(laravelToLumen($this->laravel)['config']['app.cipher'])
        );
    }

    /**
     * Set the application key in the environment file.
     *
     * @param  string  $key
     * @param  string $publicKey
     * @param  string $privateKey
     * @return bool
     */
    protected function setKeyInEnvironmentFile($key, $publicKey = '', $privateKey = '')
    {
        $currentKey = config('app.key');

        if (strlen($currentKey) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key, $publicKey, $privateKey);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param  string  $key
     * @param  string $publicKey
     * @param  string $privateKey
     * @return void
     */
    protected function writeNewEnvironmentFileWith($key, $publicKey = '', $privateKey = '')
    {
        file_put_contents(environmentFilePath(), preg_replace(
            $this->keyReplacementPattern(),
            [
                'APP_KEY='.$key,
                'APP_PUBLIC_KEY='.$publicKey,
                'APP_PRIVATE_KEY='.$privateKey
            ],
            file_get_contents(environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string|string[]
     */
    protected function keyReplacementPattern()
    {
        $keyEscaped = preg_quote('='.laravelToLumen($this->laravel)['config']['app.key'], '/');
        $publicEscaped = preg_quote('='.laravelToLumen($this->laravel)['config']['app.public_key'], '/');
        $privateEscaped = preg_quote('='.laravelToLumen($this->laravel)['config']['app.private_key'], '/');

        return ["/^APP_KEY{$keyEscaped}/m", "/^APP_PUBLIC_KEY{$publicEscaped}/m", "/^APP_PRIVATE_KEY{$privateEscaped}/m"];
    }
}
