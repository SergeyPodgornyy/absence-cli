<?php

namespace App\Interfaces;

/**
 * Interface InputLoaderInterface
 * Load incoming data
 */
interface InputLoaderInterface
{
    /**
     * @return array
     */
    public function get() : array;
}
