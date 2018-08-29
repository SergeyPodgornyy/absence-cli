<?php

namespace App\Entities;

use App\Traits\PropertyAwareTrait;

/**
 * Class InputEntity
 *
 * @property string     $fullName
 * @property string     $birthDate
 * @property string     $startDate
 * @property int|null   $vacationDays
 */
class VacationEntity
{
    use PropertyAwareTrait;

    /** @var string */
    private $fullName;

    /** @var string */
    private $birthDate;

    /** @var string */
    private $startDate;

    /** @var int|null */
    private $vacationDays;
}
