<?php

namespace App\Traits;

trait PropertyAwareTrait
{
    public function __get($property)
    {
        $methodName = 'get'.studly_case($property);

        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        } elseif (property_exists($this, $property)) {
            return $this->$property;
        }

        $trace = debug_backtrace();
        $fileName = $trace[0]['file'] ?? __FILE__;
        $line = $trace[0]['line'] ?? __LINE__;
        trigger_error("Undefined property {$property} in {$fileName} on line {$line}");

        return null;
    }

    public function __set($property, $value)
    {
        $methodName = 'set'.studly_case($property);
        if (method_exists($this, $methodName)) {
            return $this->$methodName($value);
        } elseif (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public function __isset($property)
    {
        return isset($this->$property);
    }

    public function __unset($property)
    {
        unset($this->$property);
    }
}
