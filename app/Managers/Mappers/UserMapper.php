<?php

namespace App\Managers\Mappers;

use App\Entities\UserEntity;
use App\Interfaces\UserAdapterInterface;

class UserMapper
{
    /**
     * @var UserAdapterInterface
     */
    private $adapter;

    public function __construct(UserAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function get() : UserEntity
    {
        $entity = new UserEntity();

        $entity->fullName = $this->adapter->getFullName();
        $entity->birthDate = $this->adapter->getBirthDate();
        $entity->startDate = $this->adapter->getStartDate();
        $entity->vacationDays = $this->adapter->getVacationDays();

        return $entity;
    }
}
