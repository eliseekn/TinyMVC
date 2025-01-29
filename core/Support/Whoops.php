<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Support;

use Exception as BaseException;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Exception extends BaseException
{
}

/**
 * Register Whoops.
 */
class Whoops
{
    /**
     * Register whoops instance.
     */
    public static function register(): void
    {
        $run = new Run();
        $handler = new PrettyPageHandler();
        $handler->setApplicationPaths([APP_ROOT]);
        $run->pushHandler($handler);
        $run->register();
    }
}
