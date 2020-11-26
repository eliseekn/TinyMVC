<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

/**
 * Application configuration
 */

$config = [
    'app' => [
        'name' => 'TinyMVC',
        'folder' => '/tinymvc', //or leave empty if you are using 'www' root
        'url' => 'http://localhost/tinymvc', //do not forget to remove folder if you are using 'www' root
        'lang' => 'en'
    ],

    //mysql
    'db' => [
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'host' => 'localhost',
        'name' => 'test',
        'username' => 'root',
        'password' => 'root',
        'table_prefix' => '',
        'timestamps' => true
    ],

    //smtp
    'mailer' => [
        'host' => 'localhost',
        'port' => 25,
        'username' => '',
        'password' => '',
        'from' => 'admin@mail.com',
        'name' => 'Admin'
    ],

    'errors' => [
        'display' => true,

        'views' => [
            '404' => 'errors' . DIRECTORY_SEPARATOR . '404',
            '403' => 'errors' . DIRECTORY_SEPARATOR . '404'
        ]
    ],

    'security' => [
        'enc_key' => base64_encode('write_something_here_to_generate_a_single_encryption_key'),

        'auth' => [
            'max_attempts' => 50,
            'unlock_timeout' => 1,
            'email_confirmation' => false
        ]
    ],

    'storage' => [
        'public' => APP_ROOT . 'public' . DIRECTORY_SEPARATOR,
        'routes' => APP_ROOT . 'routes' . DIRECTORY_SEPARATOR,
        'views' => APP_ROOT . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
        'migrations' => APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Migrations' . DIRECTORY_SEPARATOR,
        'seeds' => APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Seeds' . DIRECTORY_SEPARATOR,
        'stubs' => APP_ROOT . 'resources' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR,
        'controllers' => APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR,
        'models' => APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR,
        'middlewares' => APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Middlewares' . DIRECTORY_SEPARATOR,
        'requests' => APP_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR
    ],

    'session' => [
        'lifetime' => 3600 * 2, //1 hour in seconds
        
        'history' => [
            'excludes' => [
                'api'
            ]
        ]
    ]
];
