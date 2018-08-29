<?php

namespace App\Managers\Loaders\Input;

use App\Interfaces\InputLoaderInterface;
use App\Managers\Adapters\DatabaseUserAdapter;
use App\Managers\Mappers\UserMapper;
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
            $adapter = new DatabaseUserAdapter($item);

            $result[$key] = (new UserMapper($adapter))->get();
        }

        return $result;
    }
}
