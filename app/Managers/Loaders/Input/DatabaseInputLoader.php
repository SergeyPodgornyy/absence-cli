<?php

namespace App\Managers\Loaders\Input;

use App\Entities\VacationEntity;
use App\Interfaces\InputLoaderInterface;
use Illuminate\Support\Facades\DB;

class DatabaseInputLoader implements InputLoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function get() : \SplFixedArray
    {
        $count = DB::table('users')->count('id');

        $result = new \SplFixedArray($count);
        $data = DB::table('users')->get(['full_name', 'birth_date', 'start_date', 'vacation_days']);

        foreach ($data as $key => $item) {
            $entity = new VacationEntity();
            $entity->fullName = $item->full_name;
            $entity->birthDate = $item->birth_date;
            $entity->startDate = $item->start_date;
            $entity->vacationDays = $item->vacation_days ?: null;

            $result[$key] = $entity;
        }

        return $result;
    }
}
