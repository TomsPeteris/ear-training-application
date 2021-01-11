<?php

namespace App\Services;

use App\Contracts\Profile\DeletesUserProfile;

class Profile
{
    /**
     * Register a class / callback that should be used to delete user profile.
     *
     * @param string $callback
     * @return void
     */
    public static function deleteUserProfileUsing(string $callback)
    {
        return app()->singleton(DeletesUserProfile::class, $callback);
    }
}
