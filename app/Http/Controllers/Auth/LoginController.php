<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Controllers\Auth;

use App\Http\Validators\Auth\LoginValidator;
use Core\Routing\Attributes\Route;
use Core\Routing\Controller;
use Core\Support\Alert;
use Core\Support\Auth;

class LoginController extends Controller
{
    #[Route('GET', '/login', ['remember'])]
    public function index(): void
    {
        if (! Auth::check($this->request)) {
            $this->render('auth.login');
        }

        $this->redirectUrl(config('app.home'));
    }

    #[Route('POST', middlewares: ['csrf'])]
    public function authenticate(LoginValidator $validator): void
    {
        if (Auth::attempt($this->response, $this->request)) {
            Alert::toast(__('welcome', ['name' => Auth::get('name')]))->success();
            $this->redirectUrl(config('app.home'));
        }

        Alert::default(__('login_failed'))->error();

        $this->response
            ->url('/login')
            ->withInputs($this->request->only(['email', 'password']))
            ->withErrors([__('login_failed')])
            ->send();
    }
}
