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
use Core\Support\Encryption;

/**
 * Authenticate user by api token.
 */
class ApiAuth
{
    public function handle(Request $request, Response $response): void
    {
        if (empty($request->getHttpAuth())) {
            $response->json([__('auth_required')])->send(401);
        }

        list($method, $token) = $request->getHttpAuth();

        if (trim($method) !== 'Bearer') {
            $response->json([__('invalid_auth_method')])->send(400);
        }

        if (! Auth::checkToken(Encryption::decrypt($token), $user)) {
            $response->json([__('invalid_credentials')])->send(401);
        }
    }
}
