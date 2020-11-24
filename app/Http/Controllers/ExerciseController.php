<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Question;
use App\Services\ExerciseGenerator;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * @var ExerciseGenerator
     */
    private $exerciseGenerator;

    /**
     * ExerciseController constructor.
     * @param ExerciseGenerator $exerciseGenerator
     */
    public function __construct(ExerciseGenerator $exerciseGenerator)
    {
        $this->exerciseGenerator = $exerciseGenerator;
    }

    public function index()
    {
        return Inertia::render('Exercises/Index', [
            'exercise_types' => Exercise::TYPES,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Exercises/Create', [
            'type' => $request->input('exercise_type')
        ]);
    }

    public function exercise(Request $request)
    {
        $attributes = collect($request->all());
        $exerciseContent = $this->exerciseGenerator->generateExercise($attributes);

        return Inertia::render('Exercises/Exercise', [
            'retry' => $exerciseContent['retry'],
            'count' => $exerciseContent['count'],
            'questions' => $exerciseContent['questions'],
        ]);
    }

    public function store(Request $request)
    {
        // maybe some basic validation?
        $exercise = Exercise::create([
            'user_id' => auth()->user()->id,
            'type' => $request->input('exercise_type')
        ]);

        foreach ($request->input('questions') as $question) {
            Question::create([
                'questionable_type' => $question['questionable_type'],
                'questionable_id' => $question['questionable_id'],
                'answer' => true,  //$question['answer'],
                'direction' => $question['direction'],
                'type' => $question['type'],
                'root' => $question['root']['id'],
                'exercise_id' => $exercise->id
            ]);
        }

        return redirect()->route('exercise.overview', $exercise->id);
    }

    public function overview(Exercise $exercise)
    {
        return Inertia::render('Exercises/Overview', [
            'exercise' => $exercise,
        ]);
    }
}
