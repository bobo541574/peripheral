<?php

use App\Models\User;
use Illuminate\Support\Str;

if (! function_exists('get_current_active_user')) {
    function get_current_active_user()
    {
        if (request()->slug) {
            $user = User::where('slug', request()->slug)->first();

            if ($user) {
                return $user;
            }
        } else {
            return auth()->user();
        }

        return null;
    }
}

if (! function_exists('slug')) {
    function slug($data)
    {
       return Str::slug($data . now()->toDateTimeString());
    }
}