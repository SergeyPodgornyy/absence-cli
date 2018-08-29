<?php

namespace App\Interfaces;

/**
 * Interface UserAdapterInterface
 * Adapt data from different sources to be mapped to entity
 */
interface UserAdapterInterface
{
    /**
     * @return string
     */
    public function getFullName() : string;

    /**
     * @return string
     */
    public function getBirthDate() : string;

    /**
     * @return string
     */
    public function getStartDate() : string;

    /**
     * @return int|null
     */
    public function getVacationDays() : ?int;
}
