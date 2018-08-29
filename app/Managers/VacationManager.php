<?php

namespace App\Managers;

class VacationManager
{
    /** @var int */
    private $minVacationDays;

    public function __construct(int $minVacationDays)
    {
        $this->minVacationDays = $minVacationDays;
    }
}
