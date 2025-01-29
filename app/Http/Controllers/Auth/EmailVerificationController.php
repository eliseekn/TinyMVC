<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Controllers\Auth;

use App\Database\Models\Token;
use App\Enums\TokenDescription;
use App\Http\UseCases\User\UpdateUseCase;
use App\Mails\VerificationMail;
use App\Mails\WelcomeMail;
use Core\Routing\Attributes\Route;
use Core\Routing\Controller;
use Core\Support\Alert;

/**
 * Manage email verification link.
 */
class EmailVerificationController extends Controller
{
    #[Route('GET', '/email/notify')]
    public function notify(): void
    {
        $tokenValue = generate_token(15);
        $token = Token::findByDescription($this->request->queries('email'), TokenDescription::EMAIL_VERIFICATION);

        if ($token) {
            $token->update(['value' => $tokenValue]);
        } else {
            (new Token())->create([
                'email' => $this->request->queries('email'),
                'value' => $tokenValue,
                'expires_at' => carbon()->addDay()->toDateTimeString(),
                'description' => TokenDescription::EMAIL_VERIFICATION,
            ]);
        }

        if (! VerificationMail::send($this->request->queries('email'), $tokenValue)) {
            Alert::default(__('email_verification_link_not_sent'))->error();
            $this->render('auth.signup');
        }

        Alert::default(__('email_verification_link_sent'))->success();
        $this->render('auth.login');
    }

    #[Route('GET', '/email/verify')]
    public function verify(UpdateUseCase $updateUseCase): void
    {
        if (! $this->request->hasQuery(['email', 'token'])) {
            $this->response(__('bad_request'), 400);
        }

        $token = Token::findByDescription($this->request->queries('email'), TokenDescription::EMAIL_VERIFICATION);

        if (! $token || $token->get('value') !== $this->request->queries('token')) {
            $this->response(__('invalid_password_reset_link'), 400);
        }

        if (carbon($token->get('expires_at'))->lt(carbon())) {
            $this->response(__('expired_password_reset_link'), 400);
        }

        $token->delete();
        $user = $updateUseCase->handle(['email_verified_at' => carbon()->toDateTimeString()], $this->request->queries('email'));

        if (! $user) {
            Alert::default(__('account_not_found'))->error();
            $this->redirectUrl('/signup');
        }

        WelcomeMail::send($user->get('email'), $user->get('name'));
        Alert::default(__('email_verified_at'))->success();

        $this->redirectUrl('/login');
    }
}
