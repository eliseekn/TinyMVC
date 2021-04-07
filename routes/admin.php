<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

use Framework\Routing\Route;
use App\Controllers\Admin\UsersController;
use App\Controllers\Admin\MediasController;
use App\Controllers\Admin\MessagesController;
use App\Controllers\Admin\SettingsController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ActivitiesController;
use App\Controllers\Admin\NotificationsController;

/**
 * Admin panel routes
 */

Route::groupPrefix('admin', function () {
    Route::groupMiddlewares(['remember', 'dashboard'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('resources/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('resources/users/new', [UsersController::class, 'new'])->name('users.new');
        Route::get('resources/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit')->where(['id' => 'num']);
        Route::get('resources/users/{id}/read', [UsersController::class, 'read'])->name('users.read')->where(['id' => 'num']);

        Route::get('resources/medias', [MediasController::class, 'index'])->name('medias.index');
        Route::get('resources/medias/search', [MediasController::class, 'search'])->name('medias.search');
        Route::get('resources/medias/search?q=', [MediasController::class, 'search'])->name('medias.search.q');
        Route::get('resources/medias/new', [MediasController::class, 'new'])->name('medias.new');
        Route::get('resources/medias/{id}/edit', [MediasController::class, 'edit'])->name('medias.edit')->where(['id' => 'num']);
        Route::get('resources/medias/{id}/read', [MediasController::class, 'read'])->name('medias.read')->where(['id' => 'num']);
        Route::get('resources/medias/{id}/download', [MediasController::class, 'download'])->name('medias.download')->where(['id' => 'num']);

        Route::get('account/messages', [MessagesController::class, 'index'])->name('messages.index');
        Route::get('account/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
        Route::get('account/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('account/activities', [ActivitiesController::class, 'index'])->name('activities.index');
    });

    Route::groupMiddlewares(['remember', 'dashboard', 'csrf'], function () {
        Route::delete('resources/users/?{id}?/delete', [UsersController::class, 'delete'])->name('users.delete')->where(['id' => 'num']);
        Route::patch('resources/users/?{id}?/update', [UsersController::class, 'update'])->name('users.update')->where(['id' => 'num']);
    
        Route::delete('resources/medias/?{id}?/delete', [MediasController::class, 'delete'])->name('medias.delete')->where(['id' => 'num']);
        Route::patch('resources/medias/?{id}?/update', [MediasController::class, 'update'])->name('medias.update')->where(['id' => 'num']);
    
        Route::delete('account/messages/?{id}?/delete', [MessagesController::class, 'delete'])->name('messages.delete')->where(['id' => 'num']);
        Route::patch('account/messages/?{id}?/update', [MessagesController::class, 'update'])->name('messages.update')->where(['id' => 'num']);
    
        Route::delete('account/notifications/?{id}?/delete', [NotificationsController::class, 'delete'])->name('notifications.delete')
            ->where(['id' => 'num']);
        Route::patch('account/notifications/?{id}?/update', [NotificationsController::class, 'update'])->name('notifications.update')
            ->where(['id' => 'num']);
    
        Route::patch('account/settings/{id}/update', [SettingsController::class, 'update'])->name('activities.update')->where(['id' => 'num']);
        Route::delete('account/settings/activities/?{id}?/delete', [ActivitiesController::class, 'delete'])->name('activities.delete')->where(['id' => 'num']);
    });

    Route::groupMiddlewares(['remember', 'csrf', 'sanitize', 'dashboard' ], function () {
        Route::post('resources/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('resources/users/export', [UsersController::class, 'export'])->name('users.export');
    
        Route::post('resources/medias/create', [MediasController::class, 'create'])->name('medias.create');
    
        Route::post('account/notifications/create', [NotificationsController::class, 'create'])->name('notifications.create');
    
        Route::post('account/messages/create', [MessagesController::class, 'create'])->name('messages.create');
        Route::post('account/messages{id}/reply', [MessagesController::class, 'reply'])->name('messages.reply')->where(['id' => 'num']);
    
        Route::post('account/activities/export', [ActivitiesController::class, 'create'])->name('activities.export');
    });
})->register();
