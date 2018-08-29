<?php

namespace App\Entities;

use App\Traits\PropertyAwareTrait;

/**
 * Class VacationEntity
 *
 * @property string $fullName
 * @property int    $year
 * @property int    $vacationDays
 */
class VacationEntity
{
    use PropertyAwareTrait;

    /** @var string */
    private $fullName;

    /** @var int */
    private $year;

    /** @var int|null */
    private $vacationDays;
}
