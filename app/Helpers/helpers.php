<?php

if (!function_exists('checkUserRole')) {
    function checkUserRole($roles) {
        $userRoles = session('user_roles');
        return is_array($userRoles) && in_array($role, $userRoles);
    }
}
