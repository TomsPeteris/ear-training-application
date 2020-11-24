<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\Exercise;
use App\Models\Interval;
use App\Models\User;
use App\Services\ExerciseGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_member_can_access_dashboard()
    {
        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->get(route('dashboard'))
            ->assertOk();
    }

    /** @test */
    public function a_member_can_access_exercise_section()
    {
        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->get(route('exercises'))
            ->assertOk();
    }

    /** @test */
    public function a_member_can_access_exercise_creation_form()
    {
        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.create'), $attributes)
            ->assertOk();
    }

    /** @test */
    public function a_member_can_create_an_interval_exercise()
    {
        $this->withoutExceptionHandling();
        Note::factory()->count(10)->create();

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'question_attributes' => [
                'intervals' => Interval::factory()->count(10)->create(),
                'direction' => 'ascending',
                'type' => 'melodic',
            ],
            'retry' => false,
            'count' => 2,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise'), $attributes)
            ->assertOk();
    }

    /** @test */
    public function a_member_can_complete_an_interval_exercise()
    {
        $exerciseGenerator = new ExerciseGenerator();
        Note::factory()->count(10)->create();

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'question_attributes' => [
                'intervals' => Interval::factory()->count(10)->create(),
                'direction' => 'ascending',
                'type' => 'melodic',
            ],
            'retry' => false,
            'count' => 2,
        ];

        $exerciseContent = $exerciseGenerator->generateExercise(collect($attributes));
        $exerciseContent->forget(['retry', 'question_Attributes']);

        $response = $this->actingAs(User::factory()->create(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.store'), $exerciseContent->toArray());

        $exercise = Exercise::find(1)->first();

        $response->assertRedirect(route('exercise.overview', $exercise->id));
    }
}
