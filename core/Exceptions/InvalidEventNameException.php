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
 * This exception occurs when controller not found.
 */
class InvalidEventNameException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid event name');
    }
}
