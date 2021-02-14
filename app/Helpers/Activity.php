<?php

namespace App\Helpers;

use Framework\Http\Request;
use App\Database\Models\ActivitiesModel;

class Activity
{    
    /**
     * log user action
     *
     * @param  string $action
     * @param  string $user
     * @return void
     */
    public static function log(string $action, ?string $user = null): void
    {
        ActivitiesModel::insert([
            'user' => is_null($user) ? Auth::get()->email : $user,
            'url' => Request::getFullUri(),
            'method' => Request::getMethod(),
            'ip_address' => Request::getRemoteIP(),
            'action' => $action
        ]);
    }
}
