<?php

namespace App\Managers\Adapters;

use App\Interfaces\UserAdapterInterface;

class FileUserAdapter implements UserAdapterInterface
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getFullName() : string
    {
        return $this->data['full_name'];
    }

    public function getBirthDate() : string
    {
        return $this->data['birth_date'];
    }

    public function getStartDate() : string
    {
        return $this->data['start_date'];
    }

    public function getVacationDays() : ?int
    {
        return $this->data['vacation_days'] ?: null;
    }
}
