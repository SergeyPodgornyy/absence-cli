<?php

namespace App\Commands;

use App\Interfaces\InputLoaderInterface;
use App\Interfaces\OutputLoaderInterface;
use App\Managers\VacationManager;
use LaravelZero\Framework\Commands\Command;

class CalculateVacationCommand extends Command
{
    /** @var InputLoaderInterface */
    private $inputLoader;

    /** @var OutputLoaderInterface */
    private $outputLoader;

    /** @var VacationManager */
    private $manager;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'vacation:calculate {--year= : The year of vacation sheet}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Calculate number of vacation days for a given year';

    public function __construct(
        InputLoaderInterface $inputLoader,
        OutputLoaderInterface $outputLoader,
        VacationManager $manager
    ) {
        parent::__construct();

        $this->inputLoader = $inputLoader;
        $this->outputLoader = $outputLoader;
        $this->manager = $manager;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $year = $this->hasOption('year') && $this->option('year')
            ? $this->option('year')
            : $this->ask('Which working year should be counted?', \date('Y'));

        /** @var \SplFixedArray[App\Entities\UserEntity] $data */
        $data = $this->inputLoader->get();

        /** @var \SplFixedArray[App\Entities\VacationEntity] $data */
        $result = $this->manager->calculate($data, $year);

        $this->outputLoader->output($year, $result);

        $this->notify('Hey you', "Vacation report for $year done!", storage_path('logo.png'));
    }
}
