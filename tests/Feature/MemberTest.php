<?php

namespace Tests\Feature;

use App\Actions\Exercise\GenerateExercise;
use App\Models\Note;
use App\Models\Exercise;
use App\Models\Interval;
use App\Models\User;
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
            ->get(route('exercise'))
            ->assertOk();
    }

    /** @test */
    public function a_member_can_access_interval_exercise_creation_form()
    {
        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->get(route('exercise.interval'), $attributes)
            ->assertOk();
    }

    /** @test */
    public function a_member_can_create_an_interval_exercise()
    {
        $this->withoutExceptionHandling();
        Note::factory()->count(10)->create();

        $intervals = Interval::factory()->count(10)->create()->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervals->toArray(),
            'direction' => 'ascending',
            'type' => 'melodic',
            'retry' => false,
            'question_count' => 2,
        ];

        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.execute'), $attributes)
            ->assertOk();
    }

    /** @test
     * @throws \Illuminate\Validation\ValidationException
     */
    public function a_member_can_complete_an_interval_exercise()
    {
        $this->withoutExceptionHandling();

        $generator = new GenerateExercise();
        Note::factory()->count(10)->create();

        $intervals = Interval::factory()->count(10)->create();
        $intervalNames = $intervals->map(function ($interval) {
            return $interval->name;
        });

        $attributes = [
            'exercise_type' => Exercise::INTERVAL_TYPE,
            'intervals' => $intervalNames->toArray(),
            'direction' => 'ascending',
            'type' => 'melodic',
            'retry' => false,
            'question_count' => 1,
        ];

        $questions = [
            [
                'questionable_type' => get_class($intervals->random()),
                'questionable_id' => $intervals->random()->id,
                'direction' => 'ascending',
                'type' => 'melodic',
                'answer' => true,
                'exercise_id' => 1
            ]
        ];

        $exerciseContent = $generator->generate($attributes);
        $exerciseContent->put('questions', $questions);
        $exerciseContent->put('accuracy', 50);

        $response = $this->actingAs(User::factory()->create(['role' => User::MEMBER_ROLE]))
            ->post(route('exercise.store'), $exerciseContent->toArray());

        $exercise = Exercise::find(1)->first();

        $response->assertRedirect(route('history.overview', $exercise->id));
    }
}
