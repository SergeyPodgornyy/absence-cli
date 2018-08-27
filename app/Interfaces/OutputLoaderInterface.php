<?php

namespace App\Interfaces;

/**
 * Interface InputLoaderInterface
 * Output processed data
 */
interface OutputLoaderInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function output(array $data) : void;
}
