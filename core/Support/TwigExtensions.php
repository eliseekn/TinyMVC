<?php

/**
 * @copyright (2019 - 2024) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Support;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;

/**
 * Manage twig extensions and filters
 */
class TwigExtensions extends AbstractExtension implements GlobalsInterface
{    
    public function getCustomFunctions(): array
    {
        $functions = [];

        foreach (config('twig.extensions.functions') as $name => $callable) {
            $functions[] = new TwigFunction($name, $callable);
        }

        return $functions;
    }

    public function getCustomFilters(): array
    {
        $filters = [];

        foreach (config('twig.extensions.filters') as $name => $callable) {
            $filters[] = new TwigFilter($name, $callable);
        }

        return $filters;
    }

    public function getCustomGlobals(): array
    {
        $globals = [];

        foreach (config('twig.extensions.globals') as $name => $callable) {
            $globals[$name] = $callable;
        }

        return $globals;
    }

    public function getGlobals(): array
    {
        return $this->getCustomGlobals();
    }

    public function getFilters(): array
    {
        return $this->getCustomFilters();
    }

    public function getFunctions(): array
    {
        return $this->getCustomFunctions() + [
            new TwigFunction('auth_attempts_exceeded', 'auth_attempts_exceeded'),
            new TwigFunction('auth', 'auth'),
            new TwigFunction('method_input', 'method_input'),
            new TwigFunction('csrf_token_input', 'csrf_token_input'),
            new TwigFunction('csrf_token_meta', 'csrf_token_meta'),
            new TwigFunction('url', 'url'),
            new TwigFunction('route', 'route'),
            new TwigFunction('assets', 'assets'),
            new TwigFunction('resources', 'resources'),
            new TwigFunction('storage', 'storage'),
            new TwigFunction('current_url', 'current_url'),
            new TwigFunction('url_contains', 'url_contains'),
            new TwigFunction('config', 'config'),
            new TwigFunction('__', '__'),
            new TwigFunction('env', 'env'),
            new TwigFunction('date', 'date'),
            new TwigFunction('session', 'session'),
            new TwigFunction('cookies', 'cookies'),
        ];
    }
}
