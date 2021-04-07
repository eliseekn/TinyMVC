<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

/**
 * Database configuration
 */

$config = [
    'mysql' => [
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'host' => 'localhost',
        'name' => 'test',
        'username' => 'root',
        'password' => 'root',
        'table_prefix' => '',
        'timestamps' => true,
        'storage_engine' => 'InnoDB'
    ]
];