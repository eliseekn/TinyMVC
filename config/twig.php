<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

/**
 * Twig configuration
 */

$config = [
    'twig' => [
        'disable_cache' => false,
        'extensions' => [
            'functions' => [],
            'filters' => [],
            'globals' => [
                'USER_ROLE' => \App\Database\Models\Roles::ROLE,
                'MEDIA_TYPE' => \App\Database\Models\Medias::TYPE
            ]
        ]
    ]
];
