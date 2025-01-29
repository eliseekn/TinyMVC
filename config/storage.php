<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

/*
 * Storage configuration
 */

return [
    'uploads' => absolute_path('storage.uploads'),
    'public' => absolute_path('public'),
    'routes' => absolute_path('routes'),
    'views' => absolute_path('views'),
    'migrations' => absolute_path('app.Database.Migrations'),
    'seeders' => absolute_path('app.Database.Seeders'),
    'factories' => absolute_path('app.Database.Factories'),
    'stubs' => absolute_path('core.Stubs'),
    'lang' => absolute_path('resources.lang'),
    'controllers' => absolute_path('app.Http.Controllers'),
    'models' => absolute_path('app.Database.Models'),
    'middlewares' => absolute_path('app.Http.Middlewares'),
    'validators' => absolute_path('app.Http.Validators'),
    'rules' => absolute_path('app.Http.Validators.Rules'),
    'logs' => absolute_path('storage.logs'),
    'cache' => absolute_path('storage.cache'),
    'mails' => absolute_path('app.Mails'),
    'helpers' => absolute_path('app.Helpers'),
    'exceptions' => absolute_path('app.Exceptions'),
    'tests' => absolute_path('tests'),
    'console' => absolute_path('app.Console'),
    'sqlite' => absolute_path('storage.sqlite'),
    'useCases' => absolute_path('app.Http.UseCases'),
    'events' => absolute_path('app.Events'),
];
