<?php

namespace App\Providers;

use App\Exceptions\InputSourceException;
use App\Interfaces\InputLoaderInterface;
use App\Interfaces\OutputLoaderInterface;
use App\Managers\Loaders\Input\DatabaseInputLoader;
use App\Managers\Loaders\Input\JsonInputLoader;
use App\Managers\Loaders\Output\FileOutputLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const INPUT_JSON = 'json';
    public const INPUT_DATABASE = 'database';

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->setUpInputLoader();
        $this->setUpOutputLoader();
    }

    /**
     * @throws InputSourceException
     */
    private function setUpInputLoader() : void
    {
        switch ($source = env('INPUT_SOURCE', self::INPUT_DATABASE)) {
            case self::INPUT_JSON:
                $this->app->bind(InputLoaderInterface::class, JsonInputLoader::class);
                break;
            case self::INPUT_DATABASE:
                $this->app->bind(InputLoaderInterface::class, DatabaseInputLoader::class);
                break;
            default:
                throw new InputSourceException($source);
        }
    }

    private function setUpOutputLoader() : void
    {
        $this->app->bind(OutputLoaderInterface::class, FileOutputLoader::class);
    }
}
