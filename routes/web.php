<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

use Framework\Routing\Route;
use App\Controllers\HomeController;

/**
 * Web routes
 */

Route::get('/', [
    'handler' => [HomeController::class, 'index']
]);
