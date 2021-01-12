<?php

namespace App\Services;

use App\Contracts\Note\UpdatesNote;

class Note
{
    /**
     * Register a class / callback that should be used to delete user profile.
     *
     * @param string $callback
     * @return void
     */
    public static function updateNoteUser(string $callback)
    {
        return app()->singleton(UpdatesNote::class, $callback);
    }
}
