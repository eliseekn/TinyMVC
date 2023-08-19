<?php

/**
 * @copyright (2019 - 2023) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered\UserRegisteredEvent;
use App\Http\Actions\User\StoreAction;
use App\Http\Validators\Auth\RegisterValidator;
use Core\Routing\Controller;
use Core\Support\Alert;
use Core\Support\Auth;

class RegisterController extends Controller
{
    public function index(): void
    {
        if (!Auth::check($this->request)) {
            $this->render('auth.signup');
        }

        $uri = !$this->session->has('intended') ? config('app.home') : $this->session->pull('intended');
        $this->redirectUrl($uri);
    }

    public function register(StoreAction $action): void
    {
        $validated = $this->validate(new RegisterValidator());
        $user = $action->handle($validated);

        if (config('security.auth.email_verification')) {
            $this->redirectUrl('/email/notify' , ['email' => $user->attribute('email')]);
        }

        UserRegisteredEvent::dispatch([$user]);

        Alert::default(__('account_created'))->success();
        $this->redirectUrl('/login');
    }
}
