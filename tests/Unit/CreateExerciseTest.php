<?php

namespace Tests\Unit;

use App\Models\Exercise;
use App\Models\Interval;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateExerciseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function intervals_are_required()
    {
        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'direction' => 'ascending',
            'type' => 'melodic',
            'retry' => false,
            'question_count' => 2,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertSessionHasErrorsIn('generateExercise', 'intervals');
    }

    /** @test */
    public function direction_parameter_is_required()
    {
        $intervals = Interval::factory()->count(10)->create()->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervals->toArray(),
            'type' => 'melodic',
            'retry' => false,
            'question_count' => 2,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertSessionHasErrorsIn('generateExercise', 'direction');
    }

    /** @test */
    public function type_parameter_is_required()
    {
        $intervals = Interval::factory()->count(10)->create()->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervals->toArray(),
            'direction' => 'ascending',
            'retry' => false,
            'question_count' => 2,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertSessionHasErrorsIn('generateExercise', 'type');
    }

    /** @test */
    public function retry_parameter_is_required()
    {
        $intervals = Interval::factory()->count(10)->create()->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervals->toArray(),
            'direction' => 'ascending',
            'type' => 'melodic',
            'question_count' => 2,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertSessionHasErrorsIn('generateExercise', 'retry');
    }

    /** @test */
    public function count_cant_be_less_than_min_value()
    {
        $intervals = Interval::factory()->count(10)->create()->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervals->toArray(),
            'direction' => 'ascending',
            'type' => 'melodic',
            'retry' => false,
            'question_count' => 0,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertSessionHasErrorsIn('generateExercise', 'question_count');
    }

    /** @test */
    public function count_cant_be_more_than_max_value()
    {
        $intervals = Interval::factory()->count(10)->create()->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervals->toArray(),
            'direction' => 'ascending',
            'type' => 'melodic',
            'retry' => false,
            'question_count' => 51,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertSessionHasErrorsIn('generateExercise', 'question_count');
    }
}
