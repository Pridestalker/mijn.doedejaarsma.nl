<?php

namespace App;

/**
 * Checks if user is an admin
 *
 * @param User|null $user
 *
 * @return bool
 */
function is_admin($user = null)
{
    if (!$user && !\Auth::user()) {
        return false;
    }

    if (!$user) {
        $user = \Auth::user();
    }

    return $user->isAn('admin');
}
