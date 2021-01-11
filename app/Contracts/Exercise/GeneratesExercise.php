<?php

namespace App\Contracts\Exercise;

use Illuminate\Support\Collection;

interface GeneratesExercise
{
    /**
     * Generate exercise based on parameters
     *
     * @param array $parameters
     * @return Collection
     */
    public function generate(array $parameters): Collection;
}
