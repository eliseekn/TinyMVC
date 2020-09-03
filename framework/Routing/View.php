<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

namespace Framework\Routing;

use Exception;
use League\Plates\Engine;
use Framework\HTTP\Response;
use Framework\Support\Storage;

/**
 * Main view class
 */
class View
{    
    /**
     * display view page
     *
     * @param  string $template template name
     * @param  array $data data to include
     * @return void
     */
    public static function render(string $template, array $data = [], int $status_code = 200): void
    {
        if (!Storage::path('templates')->isFile($template . '.php')) {
            throw new Exception('File "' . STORAGE['templates'] . $template . '.php" not found.');
        }

        $engine = new Engine('templates');
        Response::send([], $engine->render($template, $data), $status_code);
    }
}
