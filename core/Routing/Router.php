<?php

/**
 * @copyright (2019 - 2022) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Routing;

use Closure;
use Core\Exceptions\ViewNotFoundException;
use Core\Http\Request;
use Core\Support\Session;
use Core\Http\Response;
use Core\Support\DependencyInjection;
use Core\Exceptions\RoutesNotDefinedException;
use Core\Exceptions\ControllerNotFoundException;
use Core\Exceptions\MiddlewareNotFoundException;
use Core\Exceptions\InvalidRouteHandlerException;
use Core\Exceptions\RouteHandlerNotDefinedException;

/**
 * Routing system
 */
class Router
{
    private static function match(Request $request, string $method, string $route, &$params): bool
    {
        if (
            !preg_match('/' . strtoupper($method) . '/', strtoupper($request->method())) ||
            !preg_match('#^' . $route . '$#', $request->uri(), $params)
        ) {
            return false;
        }

        array_shift($params);
            
        return true;
    }

    /**
     * @throws MiddlewareNotFoundException
     */
    private static function executeMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            $middleware = config('middlewares.' . $middleware);

            if (!class_exists($middleware) || !method_exists($middleware, 'handle')) {
                throw new MiddlewareNotFoundException($middleware);
            }

            (new DependencyInjection())->resolve($middleware, 'handle');
        }
    }

    /**
     * @throws InvalidRouteHandlerException
     * @throws ControllerNotFoundException
     */
    private static function executeHandler($handler, array $params)
    {
        if ($handler instanceof Closure) {
            return (new DependencyInjection())->resolveClosure($handler, $params);
        } 
        
        if (is_array($handler)) {
            list($controller, $action) = $handler;

            if (class_exists($controller) && method_exists($controller, $action)) {
                return (new DependencyInjection())->resolve($controller, $action, $params);
            }
            
            throw new ControllerNotFoundException("$controller/$action");
        }

        if (is_string($handler)) {
            if (class_exists($handler)) {
                return (new DependencyInjection())->resolve($handler, '__invoke', $params);
            }

            throw new ControllerNotFoundException($handler);
        }

        throw new InvalidRouteHandlerException();
    }

    public static function dispatchRoute(string $route, array $options, array $params)
    {
        if (!isset($options['handler'])) {
            throw new RouteHandlerNotDefinedException($route);
        }

        if (isset($options['middlewares'])) {
            self::executeMiddlewares($options['middlewares']);
        }

        self::executeHandler($options['handler'], $params);
    }

    /**
     * @throws ViewNotFoundException
     * @throws MiddlewareNotFoundException
     * @throws RoutesNotDefinedException
     * @throws InvalidRouteHandlerException
     * @throws RouteHandlerNotDefinedException
     * @throws ControllerNotFoundException
     */
    public static function dispatch(Request $request, Response $response)
    {   
        $routes = Route::$routes;

        if (empty($routes)) throw new RoutesNotDefinedException();

        foreach ($routes as $route => $options) {
            list($method, $route) = explode(' ', $route, 2);

            $request->method($request->inputs('_method'));

            if (self::match($request, $method, $route, $params)) {
                if (!$request->uriContains('api')) {
                    Session::push('history', [$request->uri()]);
                }

                self::dispatchRoute($route, $options, $params);
            }
        }

        $response->view(config('errors.views.404'))->send(404);
    }
}
