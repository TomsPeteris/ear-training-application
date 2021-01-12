<?php

namespace App\Contracts\Exercise;

use App\Models\Exercise;

interface StoresExerciseData
{
    /**
     * Generate exercise based on parameters
     *
     * @param array $parameters
     * @return Exercise
     */
    public function store(array $parameters): Exercise;
}
