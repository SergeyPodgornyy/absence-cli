<?php

namespace App\Providers;

use App\Interfaces\InputLoaderInterface;
use App\Interfaces\OutputLoaderInterface;
use App\Managers\Loaders\Input\FileInputLoader;
use App\Managers\Loaders\Output\FileOutputLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        $this->app->bind(InputLoaderInterface::class, FileInputLoader::class);
        $this->app->bind(OutputLoaderInterface::class, FileOutputLoader::class);
    }
}
