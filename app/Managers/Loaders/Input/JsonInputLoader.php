<?php

namespace App\Managers\Loaders\Input;

use App\Interfaces\InputLoaderInterface;
use App\Managers\Adapters\FileUserAdapter;
use App\Managers\FileManager;
use App\Managers\Mappers\UserMapper;

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
            $adapter = new FileUserAdapter($item);

            $result[$key] = (new UserMapper($adapter))->get();
        }

        return $result;
    }
}
