<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Exceptions;

use Exception;

/**
 * This exception occurs when json response data is invalid.
 */
class InvalidResponseDataException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid response data');
    }
}
