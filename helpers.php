<?php

if (!function_exists("hasPermission")) {
    function hasPermission($slug)
    {
        if (\Config::get('permission.disabled')) {
            return true;
        }
        
        if ($user = auth()->user()) {
        	return $user->hasPermission($slug);
        }

        return false;
    }
}

if (!function_exists("check_is_inspector")) {
    function check_is_inspector($inspection)
    {
        if ($inspection->inspector->id != auth()->user()->id) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['allowed only to the assigned inspector'],
            ]);
        }
    }
}