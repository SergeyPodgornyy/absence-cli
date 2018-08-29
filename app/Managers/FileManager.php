<?php

namespace App\Managers;

use Illuminate\Support\Facades\File;

class FileManager
{
    /**
     * @param $file
     * @return array
     */
    public function fromJson($file) : array
    {
        $json = File::get($file);
        $entities = json_decode($json);

        return collect($entities)->transform(function ($item) {
            return !\is_object($item) ?: (array) $item;
        })->toArray();
    }
}
