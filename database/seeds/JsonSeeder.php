<?php

use App\Managers\FileManager;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

abstract class JsonSeeder extends Seeder
{
    /** @var FileManager */
    protected $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @return ProgressBar
     */
    public function getProgressbar() : ProgressBar
    {
        $progressbar = new ProgressBar($this->command->getOutput());

        $progressbar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s% ');

        return $progressbar;
    }

    abstract protected function preExecutionCheck() : void;
}
