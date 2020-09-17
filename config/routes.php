<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

use Framework\Routing\View;
use Framework\Routing\Route;

/**
 * Set routes paths
 */

//home route
Route::get('/', [
    'handler' => function() {
        View::render('index');
    }
]);

Route::get('/home', [
    'handler' => 'HomeController@index'
]);

//auth routes
Route::group([
    '/login' => [
        'handler' => function() {
            View::render('auth/login');
        }
    ],

    '/signup' => [
        'handler' => function() {
            View::render('auth/signup');
        }
    ]
])->by([
    'method' => 'GET',
    'middlewares' => [
        'remember',
        'auth'
    ]
]);

Route::get('/logout', [
    'handler' => 'Auth\AuthController@logout'
]);

Route::post('/authenticate', [
    'handler' => 'Auth\AuthController@authenticate'
]);

Route::post('/register', [
    'handler' => 'Auth\AuthController@register'
]);

//admin routes
Route::group([
    '/admin' => ['handler' => 'Admin\AdminController@index'],
    '/admin/users' => ['handler' => 'Admin\AdminController@users'],
    '/admin/users/new' => ['handler' => 'Admin\UsersController@new'],
    '/admin/users/edit/{id:num}' => ['handler' => 'Admin\UsersController@edit'],
    '/admin/users/view/{id:num}' => ['handler' => 'Admin\UsersController@view'],
    '/admin/users/delete/{id:num}' => ['handler' => 'Admin\UsersController@delete'],
    '/admin/users/export' => ['handler' => 'Admin\UsersController@export']
])->by([
    'method' => 'GET',
    'middlewares' => [
        'remember',
        'admin'
    ]
]);

Route::group([
    '/admin/users/delete' => ['handler' => 'Admin\UsersController@delete'],
    '/admin/users/import' => ['handler' => 'Admin\UsersController@import']
])->by([
    'method' => 'POST',
    'middlewares' => [
        'remember',
        'admin'
    ]
]);

Route::group([
    '/admin/users/create' => ['handler' => 'Admin\UsersController@create'],
    '/admin/users/update/{id:num}' => ['handler' => 'Admin\UsersController@update']
])->by([
    'method' => 'POST',
    'middlewares' => [
        'csrf',
        'sanitize',
        'admin'
    ]
]);

//password forgot routes
Route::get('/password/forgot', [
    'handler' => function() {
        View::render('password/reset');
    }
]);

Route::get('/password/reset', [
    'handler' => 'Auth\PasswordResetController@reset'
]);

Route::post('/password/notify', [
    'handler' => 'Auth\PasswordResetController@notify'
]);

Route::post('/password/new', [
    'handler' => 'Auth\PasswordResetController@new'
]);
