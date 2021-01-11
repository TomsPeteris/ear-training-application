<?php

namespace App\Services;

use App\Contracts\Exercise\GeneratesExercise;
use App\Contracts\Profile\DeletesUserProfile;

class Exercise
{
    /**
     * Register a class / callback that should be used to delete user profile.
     *
     * @param string $callback
     * @return void
     */
    public static function generateExerciseUsing(string $callback)
    {
        return app()->singleton(GeneratesExercise::class, $callback);
    }
}
