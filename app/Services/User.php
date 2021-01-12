<?php

namespace App\Services;

use App\Contracts\User\DeletesUser;
use App\Contracts\User\CreatesUser;
use App\Contracts\User\UpdatesUser;

class User
{
    /**
     * Register a class / callback that should be used to delete user profile.
     *
     * @param string $callback
     * @return void
     */
    public static function updateUserUsing(string $callback)
    {
        return app()->singleton(UpdatesUser::class, $callback);
    }

    /**
     * @param string $callback
     * @return void
     */
    public static function storeUserUsing(string $callback)
    {
        return app()->singleton(CreatesUser::class, $callback);
    }

    /**
     * @param string $callback
     * @return void
     */
    public static function deleteUserUsing(string $callback)
    {
        return app()->singleton(DeletesUser::class, $callback);
    }
}
