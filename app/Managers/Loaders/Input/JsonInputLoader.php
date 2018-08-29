<?php

namespace App\Managers\Loaders\Input;

use App\Entities\VacationEntity;
use App\Interfaces\InputLoaderInterface;
use App\Managers\FileManager;

class JsonInputLoader implements InputLoaderInterface
{
    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * {@inheritdoc}
     */
    public function get() : \SplFixedArray
    {
        $data = $this->fileManager->fromJson(database_path('data/users.json'));

        $result = new \SplFixedArray(\count($data));

        foreach ($data as $key => $item) {
            $entity = new VacationEntity();
            $entity->fullName = $item['full_name'];
            $entity->birthDate = $item['birth_date'];
            $entity->startDate = $item['start_date'];
            $entity->vacationDays = $item['vacation_days'] ?: null;

            $result[$key] = $entity;
        }

        return $result;
    }
}
