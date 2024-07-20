<?php

/**
 * @copyright (2019 - 2024) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

/**
 * Events listeners
 */

return [
    'listeners' => [
        'UserRegisteredEvent' => \App\Events\UserRegistered\UserRegisteredEventListener::class
    ]
];