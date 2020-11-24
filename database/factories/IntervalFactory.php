<?php

namespace Database\Factories;

use App\Models\Interval;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntervalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Interval::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['m2', 'M2', 'm3', 'l3', 't4', 'tritone', 't5', 'm6', 'M6', 'm7', 'M7']),
            'distance' => $this->faker->numberBetween(1, 5)
        ];
    }
}
