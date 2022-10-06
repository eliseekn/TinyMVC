<?php

/**
 * @copyright (2019 - 2022) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Controllers\Auth;

use Core\Http\Request;
use Core\Support\Auth;
use Core\Support\Alert;
use Core\Support\Session;
use App\Mails\WelcomeMail;
use Core\Support\Mail\Mail;
use Core\Http\Response;
use App\Http\UseCases\User\StoreUseCase;
use App\Http\Validators\Auth\RegisterValidator;

final class RegisterController
{
    public function index(Request $request, Response $response): void
    {
        if (!Auth::check($request)) $response->view('auth.signup')->send();

        $uri = !Session::has('intended') ? config('app.home') : Session::pull('intended');
        $response->redirect($uri)->send(302);
    }

    public function register(
        Request $request,
        Response $response,
        StoreUseCase $useCase,
        RegisterValidator $registerValidator): void
    {
        $data = $registerValidator->validate($request->inputs(), $response);
        $user = $useCase->handle($data->validated());

        if (config('security.auth.email_verification')) {
            $response->redirect('/email/notify?email=' . $user->email)->send(302);
        }

        Mail::send(new WelcomeMail($user->email, $user->name));
        Alert::default(__('account_created'))->success();
        
        $response->redirect('/login')->send(302);
    }
}
