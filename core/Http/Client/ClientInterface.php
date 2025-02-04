<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Http\Client;

interface ClientInterface
{
    public static function send(string $method, $url, array $data = [], array $headers = [], bool $json = false);
}
