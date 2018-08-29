<?php

namespace App\Managers\Loaders\Output;

use App\Entities\VacationEntity;
use App\Interfaces\OutputLoaderInterface;
use League\Csv\Writer as CsvWriter;

class FileOutputLoader implements OutputLoaderInterface
{
    /**
     * {@inheritdoc}
     * @throws \League\Csv\Exception
     * @throws \League\Csv\CannotInsertRecord
     */
    public function output(int $year, \SplFixedArray $data): void
    {
        $fileName = \sprintf('result_%d_%s.csv', $year, date('Ymd_his'));
        $filePath = storage_path("output/$fileName");

        $csv = CsvWriter::createFromPath($filePath, 'w+');
        $csv->setDelimiter(',');
        $csv->setEnclosure('"');
        $csv->insertOne(['Name', 'Vacation days']);

        $csv->insertAll($this->fetchOutputData($data));

        $csv->output();
    }

    private function fetchOutputData(\SplFixedArray $data) : array
    {
        return \array_map(function (VacationEntity $entity) {
            return [
                $entity->fullName,
                $entity->vacationDays,
            ];
        }, $data->toArray());
    }
}
