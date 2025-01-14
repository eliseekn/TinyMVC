<?php

/**
 * @copyright (2019 - 2024) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Middlewares;

use Core\Support\Auth;
use Core\Http\Request;
use Core\Http\Response;
use Core\Support\Alert;

/**
 * Check if user has been authenticated
 */
class AuthPolicy
{    
    public function handle(Request $request, Response $response): void
    {
        if (!Auth::check($request)) {
            Alert::default(__('not_logged'))->error();

            $response
                ->url('/login')
                ->intended($request->fullUri())
                ->withErrors([__('not_logged')])
                ->send();
        }
    }
}
