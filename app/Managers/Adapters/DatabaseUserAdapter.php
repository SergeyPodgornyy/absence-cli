<?php

namespace App\Managers\Adapters;

use App\Interfaces\UserAdapterInterface;

class DatabaseUserAdapter implements UserAdapterInterface
{
    /** @var \stdClass */
    private $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function getFullName() : string
    {
        return $this->data->full_name;
    }

    public function getBirthDate() : string
    {
        return $this->data->birth_date;
    }

    public function getStartDate() : string
    {
        return $this->data->start_date;
    }

    public function getVacationDays() : ?int
    {
        return $this->data->vacation_days ?: null;
    }
}
