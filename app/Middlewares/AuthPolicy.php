<?php

namespace App\Middlewares;

use App\Helpers\Auth;
use Framework\HTTP\Redirect;

/**
 * Check if user is authenticated
 */
class AuthPolicy
{    
    /**
     * handle function
     *
     * @return void
     */
    public static function handle(): void
    {
        if (Auth::check()) {
            if (!Auth::hasRole('visitor')) {
                Redirect::url('admin/dashboard')->withToast(__('welcome') . ' ' . Auth::get()->name)->success();
            } else {
                Redirect::url()->withToast(__('welcome') . ' ' . Auth::get()->name)->success();
            }
        }
    }
}
