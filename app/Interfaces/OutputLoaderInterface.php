<?php

namespace App\Interfaces;

/**
 * Interface InputLoaderInterface
 * Output processed data
 */
interface OutputLoaderInterface
{
    /**
     * @param int            $year
     * @param \SplFixedArray $data
     *
     * @return void
     */
    public function output(int $year, \SplFixedArray $data) : void;
}
