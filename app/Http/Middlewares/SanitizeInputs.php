<?php

/**
 * @copyright (2019 - 2024) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Middlewares;

use Core\Http\Request;

/**
 * Sanitize form fields
 */
class SanitizeInputs
{
    public function handle(Request $request): void
    {
        foreach ($request->inputs() as $field => $value) {
            $request->set($field, sanitize($value));
        }
    }
}
