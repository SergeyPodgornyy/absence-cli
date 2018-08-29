<?php

namespace App\Providers;

use App\Exceptions\InputSourceException;
use App\Interfaces\InputLoaderInterface;
use App\Interfaces\OutputLoaderInterface;
use App\Managers\Loaders\Input\DatabaseInputLoader;
use App\Managers\Loaders\Input\JsonInputLoader;
use App\Managers\Loaders\Output\FileOutputLoader;
use App\Managers\VacationManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const INPUT_JSON = 'json';
    public const INPUT_DATABASE = 'database';

    public const INPUT_SOURCES_MAP = [
        self::INPUT_JSON        => JsonInputLoader::class,
        self::INPUT_DATABASE    => DatabaseInputLoader::class,
    ];

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

        $this->setUpVacationManager();
    }

    /**
     * @throws InputSourceException
     */
    private function setUpInputLoader() : void
    {
        $source = \env('INPUT_SOURCE', self::INPUT_DATABASE);

        if (!isset(self::INPUT_SOURCES_MAP[$source])) {
            throw new InputSourceException($source);
        }

        $this->app->bind(InputLoaderInterface::class, self::INPUT_SOURCES_MAP[$source]);
    }

    private function setUpOutputLoader() : void
    {
        $this->app->bind(OutputLoaderInterface::class, FileOutputLoader::class);
    }

    private function setUpVacationManager() : void
    {
        $this->app->when(VacationManager::class)
            ->needs('$minVacationDays')
            ->give(env('MIN_VACATION_DAYS', 26));
    }
}
