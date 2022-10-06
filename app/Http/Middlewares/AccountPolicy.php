<?php

/**
 * @copyright (2019 - 2022) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Middlewares;

use Core\Http\Request;
use Core\Http\Response;
use Core\Support\Auth;
use Core\Support\Alert;

/**
 * Check if email has been verified
 */
final class AccountPolicy
{    
    public function handle(Request $request, Response $response)
    {
        if (config('security.auth.email_verification')) {
            if (!Auth::get('email_verified')) {
                Alert::default(__('email_not_verifed'))->error();

                $response
                    ->redirect('/login')
                    ->intended($request->fullUri())
                    ->send(302);
            }
        }
    }
}
