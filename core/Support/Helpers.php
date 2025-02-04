<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

use Carbon\Carbon;
use Core\Http\Request;
use Core\Routing\Route;
use Core\Routing\View;
use Core\Support\Config;
use Core\Support\Cookies;
use Core\Support\Encryption;
use Core\Support\Session;
use Core\Support\Storage;
use Faker\Factory;

/*
 * Cookie helper
 */
if (! function_exists('cookies')) {
    function cookies(): Cookies
    {
        return new Cookies();
    }
}

/*
 * Session helper
 */
if (! function_exists('session')) {
    function session(): Session
    {
        return new Session();
    }
}

/*
 * View get content helper
 */
if (! function_exists('view')) {
    function view(string $view, array $data = []): string
    {
        return View::getContent($view, $data);
    }
}

if (! function_exists('storage')) {
    function storage(string $path = APP_ROOT): Storage
    {
        return Storage::path($path);
    }
}

if (! function_exists('auth_attempts_exceeded')) {
    function auth_attempts_exceeded(): bool
    {
        if (! config('security.auth.max_attempts')) {
            return false;
        }

        $unlock_timeout = session()->get('auth_attempts_timeout');
        $attempts = session()->get('auth_attempts');

        if (is_null($attempts) || is_null($unlock_timeout)) {
            return false;
        }

        return $attempts >= config('security.auth.max_attempts') && Carbon::parse($unlock_timeout)->gte(Carbon::now());
    }
}

if (! function_exists('auth')) {
    /**
     * Get authenticated user session data.
     */
    function auth(?string $key = null): mixed
    {
        $user = session()->get('user');

        if (is_null($user)) {
            return false;
        }

        return is_null($key) ? $user : $user[$key];
    }
}

/*
 * Security utils
 */
if (! function_exists('hash_pwd')) {
    /**
     * Hash password.
     */
    function hash_pwd(string $password): string
    {
        return Encryption::hash($password);
    }
}

if (! function_exists('sanitize')) {
    /**
     * Sanitize html and others scripting languages.
     */
    function sanitize(string $str): string
    {
        $str = stripslashes($str);
        $str = htmlspecialchars($str);

        return strip_tags($str);
    }
}

if (! function_exists('generate_csrf_token')) {
    function generate_csrf_token(): string
    {
        if (session()->has('csrf_token')) {
            $csrf_token = session()->get('csrf_token');
        } else {
            $csrf_token = generate_token();
            session()->create('csrf_token', $csrf_token);
        }

        return $csrf_token;
    }
}

if (! function_exists('csrf_token_input')) {
    /**
     * Generate crsf token html input tag.
     */
    function csrf_token_input(): string
    {
        return '<input type="hidden" name="_csrf_token" id="csrf_token" value="' . generate_csrf_token() . '">';
    }
}

if (! function_exists('csrf_token_meta')) {
    /**
     * Generate crsf token html meta tag.
     */
    function csrf_token_meta(): string
    {
        return '<meta name="csrf_token" content="' . generate_csrf_token() . '">';
    }
}

if (! function_exists('method_input')) {
    /**
     * Set custom request method with html input tag.
     */
    function method_input(string $method): string
    {
        return '<input type="hidden" name="_method" value="' . $method . '">';
    }
}

if (! function_exists('valid_csrf_token')) {
    function valid_csrf_token(string $csrf_token): bool
    {
        return hash_equals(session()->get('csrf_token'), $csrf_token);
    }
}

/*
 * Miscellaneous URL utils
 */
if (! function_exists('url')) {
    /**
     * Generate abosulte url.
     */
    function url(string $uri, $params = null): string
    {
        $url = config('app.url');

        if ($url[-1] !== '/') {
            $url .= '/';
        }

        $url .= ltrim($uri, '/');
        $params = is_array($params)
            ? (empty($params) ? '' : implode('/', $params))
            : $params;

        return is_null($params) ? $url : $url . '/' . $params;
    }
}

if (! function_exists('route_uri')) {
    function route_uri(string $name, $params = null): string
    {
        $uri = '';
        $patterns = ['([a-zA-Z-_]+)', '(\d+)', '([^/]+)'];

        foreach (Route::$routes as $route => $options) {
            if (! empty($options['name'])) {
                if ($name === $options['name']) {
                    $uri = explode(' ', $route, 2)[1];
                }
            }
        }

        if (empty($uri)) {
            throw new Exception('Route name "' . $name . '" is not defined.');
        }

        if (is_null($params)) {
            foreach ($patterns as $pattern) {
                if (strpos($uri, '+)?')) {
                    $pattern = "?$pattern?";
                }

                if (strpos($uri, $pattern)) {
                    $uri = substr_replace($uri, '', strpos($uri, $pattern), strlen($pattern));
                }
            }
        } else {
            $params = is_array($params) ? $params : [$params];
            reset($params);

            foreach ($patterns as $pattern) {
                if (strpos($uri, '+)?')) {
                    $pattern = "?$pattern?";

                    if (strpos($uri, $pattern)) {
                        $uri = substr_replace($uri, '', strpos($uri, $pattern), strlen($pattern));
                        next($params);
                        continue;
                    }
                }

                if (strpos($uri, $pattern)) {
                    $uri = substr_replace($uri, current($params), strpos($uri, $pattern), strlen($pattern));
                    next($params);
                }
            }
        }

        $uri = str_replace('//', '/', $uri);

        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        return $uri;
    }
}

if (! function_exists('route')) {
    /**
     * Get route absolute url.
     */
    function route(string $name, $params = null): string
    {
        return url(route_uri($name, $params));
    }
}

if (! function_exists('public_url')) {
    /**
     * Generate public path url.
     */
    function public_url(string $asset): string
    {
        return url('public/' . $asset);
    }
}

if (! function_exists('storage_url')) {
    /**
     * Generate storage url.
     */
    function storage_url(string $path): string
    {
        return url('storage/' . $path);
    }
}

if (! function_exists('current_url')) {
    function current_url(): string
    {
        return url((new Request())->fullUri());
    }
}

if (! function_exists('url_contains')) {
    function url_contains(string $str): bool
    {
        if (! preg_match('/' . $str . '/', explode('//', current_url())[1])) {
            return false;
        }

        return true;
    }
}

/*
 * Miscellaneous utils
 */
if (! function_exists('real_path')) {
    /**
     * Replace '.' by OS's directory separator.
     */
    function real_path(string $path): string
    {
        return str_replace('.', DIRECTORY_SEPARATOR, $path);
    }
}

if (! function_exists('absolute_path')) {
    /**
     * Generate absolute path.
     */
    function absolute_path(string $path): string
    {
        return APP_ROOT . real_path($path) . DIRECTORY_SEPARATOR;
    }
}

if (! function_exists('slugify')) {
    /**
     * @link   https://ourcodeworld.com/articles/read/253/creating-url-slugs-properly-in-php-including-transliteration-support-for-utf-8
     */
    function slugify(string $str, string $separator = '-'): string
    {
        return strtolower(
            trim(
                preg_replace(
                    '~[^0-9a-z]+~i',
                    $separator,
                    html_entity_decode(
                        preg_replace(
                            '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i',
                            '$1',
                            htmlentities($str, ENT_QUOTES, 'UTF-8')
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    )
                ),
                $separator
            )
        );
    }
}

if (! function_exists('generate_token')) {
    function generate_token(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
}

if (! function_exists('config')) {
    /**
     * Read configuration.
     */
    function config(string $data, $default = null): mixed
    {
        if (! str_contains($data, '.')) {
            return null;
        }

        $file = substr($data, 0, strpos($data, '.'));
        $data = substr($data, strpos($data, '.') + 1, strlen($data));
        $path = absolute_path('config') . $file . '.php';

        return Config::readFile($path, $data, $default);
    }
}

if (! function_exists('__')) {
    /**
     * Translate words and expressions.
     */
    function __(string $expr, array $data = []): string
    {
        return Config::readTranslations($expr, $data);
    }
}

if (! function_exists('get_file_extension')) {
    function get_file_extension(string $file): string
    {
        if (empty($file) || ! str_contains($file, '.')) {
            return '';
        }

        $file_ext = explode('.', $file);

        return end($file_ext);
    }
}

if (! function_exists('get_file_name')) {
    function get_file_name(string $file): string
    {
        if (empty($file) || ! str_contains($file, '.')) {
            return '';
        }

        $filename = explode('.', $file);

        return $filename[0];
    }
}

if (! function_exists('env')) {
    /**
     * Get environnement variable key.
     */
    function env(string $key, $default = null): mixed
    {
        return Config::readEnv($key, $default);
    }
}

if (! function_exists('parse_array')) {
    /**
     * Convert string to array.
     */
    function parse_array(array|string $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        return [$value];
    }
}

if (! function_exists('carbon')) {
    function carbon($time = null, $tz = null)
    {
        return Carbon::parse($time, $tz);
    }
}

if (! function_exists('faker')) {
    function faker()
    {
        return Factory::create(config('app.lang'));
    }
}

if (! function_exists('init_storage')) {
    function init_storage(): void
    {
        $storage = Storage::path(absolute_path('storage'));

        if (! $storage->isDir()) {
            $storage->createDir();
        }
        if (! $storage->path(config('storage.logs'))->isDir()) {
            $storage->createDir();
        }
        if (! $storage->path(config('storage.cache'))->isDir()) {
            $storage->createDir();
        }
        if (! $storage->path(config('storage.sqlite'))->isDir()) {
            $storage->createDir();
        }
    }
}

/*
 * Laravel helpers from \Illuminate\Support\helpers.php
 */
if (! function_exists('trait_uses_recursive')) {
    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param  string $trait
     * @return array
     */
    function trait_uses_recursive(string $trait): array
    {
        $traits = class_uses($trait) ?: [];

        foreach ($traits as $trait) {
            $traits += trait_uses_recursive($trait);
        }

        return $traits;
    }
}

if (! function_exists('class_uses_recursive')) {
    /**
     * Returns all traits used by a class, its parent classes and trait of their traits.
     *
     * @param  object|string $class
     * @return array
     */
    function class_uses_recursive(mixed $class): array
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $results = [];

        foreach (array_reverse(class_parents($class)) + [$class => $class] as $class) {
            $results += trait_uses_recursive($class);
        }

        return array_unique($results);
    }
}

if (! function_exists('parse_raw_http_request')) {
    /**
     * Parse raw HTTP request data.
     *
     * Pass in $a_data as an array. This is done by reference to avoid copying
     * the data around too much.
     *
     * Any files found in the request will be added by their field name to the
     * $data['files'] array.
     *
     * @ref: http://www.chlab.ch/blog/archives/webdevelopment/manually-parse-raw-http-data-php
     *
     * @return array Associative array of request data
     */
    function parse_raw_http_request(array &$a_data): array
    {
        // read incoming data
        $input = file_get_contents('php://input');

        if (! isset($_SERVER['CONTENT_TYPE'])) {
            // we expect regular puts to containt a query string containing data
            parse_str(urldecode($input), $a_data);

            return $a_data;
        }

        // grab multipart boundary from content type header
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);

        // content type is probably regular form-encoded
        if (! count($matches)) {
            // we expect regular puts to containt a query string containing data
            parse_str(urldecode($input), $a_data);

            return $a_data;
        }

        $boundary = $matches[1];

        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);

        // loop data blocks
        foreach ($a_blocks as $id => $block) {
            if (empty($block)) {
                continue;
            }

            // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

            // parse uploaded files
            if (str_contains($block, 'application/octet-stream')) {
                // match "name", then everything after "stream" (optional) except for prepending newlines
                preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
                $a_data['files'][$matches[1]] = $matches[2];
            }
            // parse all other fields
            else {
                // match "name" and optional value in between newline sequences
                preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
                $a_data[$matches[1]] = $matches[2];
            }
        }

        return $a_data;
    }
}
