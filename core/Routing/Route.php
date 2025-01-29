<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Routing;

use Closure;
use Core\Exceptions\RoutesPathsNotDefinedException;
use Core\Http\Response;
use Core\Support\Storage;
use ReflectionClass;
use ReflectionMethod;
use Spatie\StructureDiscoverer\Discover;

/**
 * Manage routes.
 */
class Route
{
    protected static string $route;

    protected static array $tmp_routes = [];

    public static array $routes = [];

    private static function add(string $route, Closure|array|string $handler): self
    {
        static::$route = self::format($route);
        static::$tmp_routes[static::$route] = ['handler' => $handler];

        return new self();
    }

    public static function get(string $uri, Closure|array|string $handler): self
    {
        return self::add('GET ' . $uri, $handler);
    }

    public static function post(string $uri, Closure|array|string $handler): self
    {
        return self::add('POST ' . $uri, $handler);
    }

    public static function delete(string $uri, Closure|array|string $handler): self
    {
        return self::add('DELETE ' . $uri, $handler);
    }

    public static function options(string $uri, Closure|array|string $handler): self
    {
        return self::add('OPTIONS ' . $uri, $handler);
    }

    public static function patch(string $uri, Closure|array|string $handler): self
    {
        return self::add('PATCH ' . $uri, $handler);
    }

    public static function put(string $uri, Closure|array|string $handler): self
    {
        return self::add('PUT ' . $uri, $handler);
    }

    public static function any(string $uri, Closure|array|string $handler): self
    {
        return self::add('GET|POST|DELETE|PUT|OPTIONS|PATCH ' . $uri, $handler);
    }

    public static function all(string $name, string $controller, array $excepts = []): self
    {
        return self::group(function () use ($name, $excepts) {
            if (! in_array('index', $excepts)) {
                self::get('/' . $name, 'index')->name('index');
            }
            if (! in_array('store', $excepts)) {
                self::post('/' . $name, 'store')->name('store');
            }
            if (! in_array('update', $excepts)) {
                self::match('PATCH|PUT', '/' . $name . '/{id:int}', 'update')->name('update');
            }
            if (! in_array('show', $excepts)) {
                self::get('/' . $name . '/{id:int}', 'show')->name('show');
            }
            if (! in_array('edit', $excepts)) {
                self::get('/' . $name . '/{id:int}/edit', 'edit')->name('edit');
            }
            if (! in_array('delete', $excepts)) {
                self::delete('/' . $name . '/{id:int}', 'delete')->name('delete');
            }
        })->byController($controller)->byName($name);
    }

    public static function match(string $methods, string $uri, Closure|array|string $handler): self
    {
        return self::add($methods . ' ' . $uri, $handler);
    }

    public static function view(string $uri, string $view, array $params = []): self
    {
        return self::get($uri, function (Response $response) use ($view, $params) {
            $response->view($view, $params)->send();
        });
    }

    public function name(string $name): self
    {
        self::$tmp_routes[self::$route]['name'] = $name;

        return $this;
    }

    public static function group($callback): self
    {
        call_user_func($callback);

        return new static();
    }

    public function middleware(array|string $middlewares): self
    {
        $middlewares = parse_array($middlewares);
        self::$tmp_routes[self::$route]['middlewares'] = $middlewares;

        return $this;
    }

    public function byMiddleware(array|string $middlewares): self
    {
        $middlewares = parse_array($middlewares);

        foreach (self::$tmp_routes as $route => $options) {
            if (isset($options['middlewares'])) {
                self::$tmp_routes[$route]['middlewares'] = array_merge($middlewares, $options['middlewares']);
            } else {
                self::$tmp_routes[$route]['middlewares'] = $middlewares;
            }
        }

        return $this;
    }

    public function byPrefix(string $prefix): self
    {
        if ($prefix[-1] === '/') {
            $prefix = rtrim($prefix, '/');
        }

        foreach (self::$tmp_routes as $route => $options) {
            list($method, $uri) = explode(' ', $route, 2);
            $_route = implode(' ', [$method, $prefix . $uri]);
            $_route = self::format($_route);
            self::$tmp_routes = self::updateRoute($route, $_route);
        }

        return $this;
    }

    public function byName(string $name): self
    {
        foreach (self::$tmp_routes as $route => $options) {
            if (isset($options['name'])) {
                self::$tmp_routes[$route]['name'] = $name . '.' . $options['name'];
            } else {
                self::$tmp_routes[$route]['name'] = $name;
            }
        }

        return $this;
    }

    public function byController(string $controller): self
    {
        foreach (self::$tmp_routes as $route => $options) {
            if (isset($options['handler'])) {
                self::$tmp_routes[$route]['handler'] = [$controller, $options['handler']];
            } else {
                self::$tmp_routes[$route]['handler'] = $controller;
            }
        }

        return $this;
    }

    public function register(): void
    {
        if (empty(self::$tmp_routes)) {
            return;
        }

        self::$routes += self::$tmp_routes;
        self::$tmp_routes = [];
    }

    private static function format(string $route): string
    {
        list($method, $uri) = explode(' ', $route, 2);

        if (empty($uri)) {
            $uri = '/';
        }

        if (strlen($uri) > 1) {
            if ($uri[0] !== '/') {
                $uri = '/' . $uri;
            }
        }

        $uri = preg_replace('/{([a-zA-Z-_]+)}/i', 'any', $uri);
        $uri = preg_replace('/{([a-zA-Z-_]+):([^\}]+)}/i', '$2', $uri);
        $uri = preg_replace('/\bstr\b/', '([a-zA-Z-_]+)', $uri);
        $uri = preg_replace('/\bint\b/', '(\d+)', $uri);
        $uri = preg_replace('/\bany\b/', '([^/]+)', $uri);

        return implode(' ', [$method, $uri]);
    }

    /**
     * @link   https://thisinterestsme.com/php-replace-array-key/
     */
    private static function updateRoute(string $old, string $new): array
    {
        $array_keys = array_keys(self::$tmp_routes);
        $old_key_index = array_search($old, $array_keys);
        $array_keys[$old_key_index] = $new;

        return array_combine($array_keys, self::$tmp_routes);
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    protected static function loadFromAttributes(): void
    {
        $controllers = Discover::in(config('storage.controllers'))->classes()->get();

        foreach ($controllers as $controller) {
            $reflectionClass = new ReflectionClass($controller);
            $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Attributes\Route::class);

                foreach ($attributes as $attribute) {
                    $attribute = $attribute->newInstance();
                    $route = self::match($attribute->methods, $attribute->uri ?? $method->getName(), [$controller, $method->getName()]);

                    if ($attribute->middlewares) {
                        $route->middleware($attribute->middlewares);
                    }

                    if ($attribute->name) {
                        $route->name($attribute->name);
                    }

                    $route->register();
                }
            }
        }
    }

    public static function load(): void
    {
        self::loadFromAttributes();

        if (empty(config('routes.paths')) && empty(self::$routes)) {
            throw new RoutesPathsNotDefinedException();
        }

        if (! empty(config('routes.paths'))) {
            $paths = array_map(function ($path) {
                $path = $path === DIRECTORY_SEPARATOR
                    ? config('storage.routes')
                    : Storage::path(config('storage.routes'))->addPath($path)->getPath();

                return str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $path);
            }, config('routes.paths'));

            foreach ($paths as $path) {
                $routes = Storage::path($path)->addPath('')->getFiles();

                foreach ($routes as $route) {
                    require_once $path . $route;
                }
            }
        }
    }
}
