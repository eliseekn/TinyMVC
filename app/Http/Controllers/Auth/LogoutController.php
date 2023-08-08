<?php

/**
 * @copyright (2019 - 2023) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Controllers\Auth;

use Core\Routing\Controller;
use Core\Support\Alert;
use Core\Support\Auth;

class LogoutController extends Controller
{
	public function __invoke(): void
	{
        Auth::forget();
        Alert::toast(__('logged_out'))->success();

        $this->redirectUrl(config('app.home'));
	}
}
