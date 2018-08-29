<?php

namespace App\Interfaces;

/**
 * Interface InputLoaderInterface
 * Load incoming data
 */
interface InputLoaderInterface
{
    /**
     * @return \SplFixedArray
     */
    public function get() : \SplFixedArray;
}
