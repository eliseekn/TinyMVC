<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Middlewares;

use Core\Http\Request;
use Core\Http\Response;
use Core\Support\Auth;

/**
 * Authenticate user by http.
 */
class HttpAuth
{
    public function handle(Request $request, Response $response): void
    {
        if (empty($request->getHttpAuth())) {
            $response->json([__('auth_required')])->send(401);
        }

        list($method, $credentials) = $request->getHttpAuth();

        if (trim($method) !== 'Basic') {
            $response->json([__('invalid_auth_method')])->send(400);
        }

        $credentials = base64_decode($credentials);
        list($email, $password) = explode(':', $credentials);

        if (! Auth::checkCredentials($email, $password, $user)) {
            $response->json([__('invalid_credentials')])->send(401);
        }
    }
}
