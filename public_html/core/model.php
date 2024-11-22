<?php

namespace Bosbar;

class Model
{
    /**
     * Constructor: Initialize as needed.
     */
    public function __construct() {   
    }

    /**
     * Destructor: Clean up if necessary.
     */
    public function __destruct() {
    }

    /**
     * Sanitizes output of a method's result if the method exists.
     * @param string $method Name of the method to process.
     * @return string|false Sanitized result or false if the method does not exist.
     */
    public function fetchSanitizedResult($method)
    {
        if ((int)method_exists($this, $method)) {
            return htmlspecialchars($this->$method());
        }
        return false;
    }

    /**
     * Populates the object with provided data, mapping keys to setters.
     * @param array $data Associative array to populate the model.
     * @return void
     */
    public function populateFromArray(array $data)
    {
        foreach ($data as $field => $value) {
            $method = 'set' . implode('', array_map('ucfirst', explode('_', $field)));
            if (is_callable([$this, $method])) {
                call_user_func([$this, $method], $value);
            }
        }
    }
}