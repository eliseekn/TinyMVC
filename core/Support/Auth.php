<?php

/**
 * @copyright (2019 - 2022) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Support;

use Carbon\Carbon;
use Core\Http\Request;
use Core\Support\Cookies;
use Core\Support\Session;
use Core\Support\Encryption;
use App\Database\Models\User;
use App\Database\Models\Token;
use Core\Http\Response;

/**
 * Manage authentications
 */
class Auth
{
    public static function getAttempts()
    {
        return Session::get('auth_attempts', 0);
    }

    public static function attempt(Response $response, array $credentials, bool $remember = false): bool
    {
        Session::push('auth_attempts', 1, 0);

        if (!self::checkCredentials($credentials['email'], $credentials['password'], $user)) {
            if (config('security.auth.max_attempts') > 0 && Auth::getAttempts() >= config('security.auth.max_attempts')) {
                $response->redirectBack()->with('auth_attempts_timeout', Carbon::now()->addMinutes(config('security.auth.unlock_timeout'))->toDateTimeString())->send(302);
            }

            return false;
        }

        Session::forget('auth_attempts', 'auth_attempts_timeout');
        Session::create('user', $user);
            
        if ($remember) Cookies::create('user', $user->email, 3600 * 24 * 365);
        
        return true;
    }
    
    public static function checkCredentials(string $email, string $password, &$user): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $user = User::findBy('email', $email);
            return $user !== false && Encryption::check($password, $user->password);
        }

        $users = User::where('email', 'like', $email)->getAll();

        if (!$users) return false;

        foreach ($users as $u) {
            if (Encryption::check($password, $u->password)) {
                $user = $u;
                return true;
            }
        }

        return false;
    }
    
    public static function checkToken(string $token, &$user): bool
    {
        $token = Token::findBy('token', $token);
        $user = User::findBy('email', $token->email);
        
        return $user !== false;
    }
    
    public static function createToken(string $email): string
    {
        $token = Token::create([
            'email' => $email,
            'token' => generate_token(),
        ]);

        return Encryption::encrypt($token->token);
    }

    public static function check(Request $request): bool
    {
        $result = Session::has('user');

        if (!$result) {
            if (empty($request->getHttpAuth())) return false;

            list($method, $token) = $request->getHttpAuth();

            $result = trim($method) === 'Bearer' && self::checkToken(Encryption::decrypt($token), $user);
        }

        return $result;
    }

    public static function remember(): bool
    {
        return Cookies::has('user');
    }
    
    public static function get(?string $key = null)
    {
        $user = Session::get('user');

        if (is_null($key)) return $user;

        return $user->{$key};
    }

    public static function forget()
    {
        Session::forget('user', 'history', 'csrf_token');

        if (self::remember()) Cookies::delete('user');
    }
}
