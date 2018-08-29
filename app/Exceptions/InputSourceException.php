<?php

namespace App\Exceptions;

class InputSourceException extends \Exception
{
    public function __construct($source, $code = 0, \Exception $previous = null)
    {
        $message = "Invalid input source type: $source";

        parent::__construct($message, $code, $previous);
    }
}
