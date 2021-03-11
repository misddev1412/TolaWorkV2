<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminAuthorizationHelper
{

    public static function check($allowed_roles = ['SUP_ADM'])
    {
        if (null === Auth::guard('admin')->user()) {
            return false;
        }
        $user = Auth::guard('admin')->user();
        $userRole = $user->getAdminUserRole();
        return in_array($userRole->role_abbreviation, $allowed_roles) ? true : false;
    }

}
