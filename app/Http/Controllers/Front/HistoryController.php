<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class HistoryController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        $exercises = Exercise::where('user_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(8)
            ->only('id', 'type', 'accuracy', 'created_at')
            ->transform(function ($item) {
                return [
                    'id' => $item['id'],
                    'type' => $item['type'],
                    'accuracy' => $item['accuracy'],
                    'date' => date('D m Y H:i', strtotime($item['created_at']))
                ];
            });

        return Inertia::render('Front/History/Index', [
            'exercises' => $exercises
        ]);
    }

    /**
     * @param Exercise $exercise
     * @return InertiaResponse
     */
    public function overview(Exercise $exercise): InertiaResponse
    {
        $previousExercise = request()->user()->exercises
            ->filter(function ($previousExercise) use ($exercise) {
                return $previousExercise->id < $exercise->id;
            })
            ->sortByDesc('id')
            ->first();

        $previousExerciseQuestions = $previousExercise ? $previousExercise->questions : null;

        return Inertia::render('Front/History/Overview', [
            'exercise' => $exercise,
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
