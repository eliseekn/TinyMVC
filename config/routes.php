<?php

/**
 * TinyMVC
 * 
 * PHP framework based on MVC architecture
 * 
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

//authentication routes
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
    'handler' => 'AuthenticationController@logout'
]);

Route::post('/authenticate', [
    'handler' => 'AuthenticationController@authenticate'
]);

Route::post('/register', [
    'handler' => 'AuthenticationController@register'
]);

//admin routes
Route::group([
    '/admin' => ['handler' => 'Admin\AdminController@index'],
    '/admin/users' => ['handler' => 'Admin\AdminController@users'],
    '/admin/users/add' => ['handler' => 'Admin\UsersController@add'],
    '/admin/users/edit/{id:num}' => ['handler' => 'Admin\UsersController@edit'],
    '/admin/users/delete/{id:num}?' => ['handler' => 'Admin\UsersController@delete']
])->by([
    'method' => 'GET',
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

Route::post('/admin/users/delete/', [
    'handler' => 'Admin\UsersController@delete',
    'middlewares' => [
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
    'handler' => 'PasswordResetController@reset'
]);

Route::post('/password/notify', [
    'handler' => 'PasswordResetController@notify'
]);

Route::post('/password/new', [
    'handler' => 'PasswordResetController@new'
]);
