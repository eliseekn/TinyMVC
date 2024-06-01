<?php

/**
 * @copyright (2019 - 2024) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Events\UserRegistered;

use App\Mails\WelcomeMail;

class UserRegisteredEventListener
{
    public function __invoke($user): void
    {
        WelcomeMail::send($user->get('email'), $user->get('name'));
    }
}
