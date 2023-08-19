<?php

/**
 * @copyright (2019 - 2023) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Mails;

use Core\Support\Mail\Mailer;

/**
 * Send welcome email notification
 */
class WelcomeMail extends Mailer
{
    public function __construct(string $email, string $name)
    {
        parent::__construct();

        $this->to($email)
            ->from(config('mailer.sender.email'), config('mailer.sender.name'))
            ->reply(config('mailer.sender.email'), config('mailer.sender.name'))
			->subject('Welcome')
            ->body(view('emails.welcome', compact('name')));
    }
}
