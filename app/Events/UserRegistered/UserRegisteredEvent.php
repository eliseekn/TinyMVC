<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Events\UserRegistered;

use Core\Events\Event;

class UserRegisteredEvent
{
    public static function dispatch(array $params = []): void
    {
        Event::dispatch('UserRegisteredEvent', $params);
    }
}
