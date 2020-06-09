<?php

namespace App\Middlewares;

use Framework\Http\Request;

/**
 * SanitizeInputs
 * 
 * Sanitize post request
 */
class SanitizeInputs
{
    /**
     * handle function
     * 
     * @return void
     */
    public static function handle(): void
    {
        foreach (Request::getInput() as $key => $value) {
            Request::setInput($key, escape($value));
        }
    }
}
