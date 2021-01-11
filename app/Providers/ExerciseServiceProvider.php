<?php

namespace App\Providers;

use App\Actions\Exercise\GenerateExercise;
use App\Services\Exercise;
use Illuminate\Support\ServiceProvider;

class ExerciseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Exercise::generateExerciseUsing(GenerateExercise::class);
    }
}
