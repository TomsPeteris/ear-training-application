<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Interval;
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
        return Inertia::render('Front/Exercises/Index', [
            'exercises' => Exercise::TYPES,
        ]);
    }

    public function interval()
    {
        return Inertia::render('Front/Exercises/Interval', [
            'type' => Exercise::INTERVAL_TYPE,
            'intervals' => Interval::all(),
        ]);
    }

    public function exercise(Request $request)
    {
        $attributes = collect($request->all());
        $exerciseContent = $this->exerciseGenerator->generateExercise($attributes);

        return Inertia::render('Front/Exercises/Exercise', [
            'exercise_type' => $exerciseContent['exercise_type'],
            'retry' => $exerciseContent['retry'],
            'playback_speed' => $exerciseContent['playback_speed'],
            'questions' => $exerciseContent['questions'],
        ]);
    }

    public function store(Request $request)
    {
        // maybe some basic validation?
        $exercise = Exercise::create([
            'user_id' => auth()->user()->id,
            'type' => $request->input('exercise_type'),
            'accuracy' => $request->input('accuracy')
        ]);

        foreach ($request->input('questions') as $question) {
            Question::create([
                'questionable_type' => $question['questionable_type'],
                'questionable_id' => $question['questionable_id'],
                'answer' => $question['answer'],
                'direction' => $question['direction'],
                'type' => $question['type'],
                'exercise_id' => $exercise->id
            ]);
        }

        return redirect()->route('exercise.overview', $exercise->id);
    }

    public function overview(Exercise $exercise)
    {
        $previousExercise = auth()->user()->exercises->filter(function ($previousExercise) use ($exercise) {
            return $previousExercise->id < $exercise->id;
        })->sortByDesc('id')->first();

        $previousExerciseQuestions = $previousExercise ? $previousExercise->questions : null;

        return Inertia::render('Front/Exercises/Overview', [
            'exerciseQuestions' => $exercise->questions->map(function ($question) {
                return [
                    'interval' => $question->questionable->name,
                    'direction' => $question->direction,
                    'type' => $question->type,
                    'answer' => $question->answer
                ];
            })->values(),
            'previousExerciseQuestions' => $previousExerciseQuestions
        ]);
    }
}
