<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Interval;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class StatisticsController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        $questions = Collection::empty();
        $intervals = Collection::empty();
        $exercises = Exercise::where('user_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $questionCollection = $exercises->map(function ($exercise) {
            return $exercise->questions;
        });
        $intervalCollection = Interval::all()->pluck('name')->toArray();

        foreach ($questionCollection as $question) {
            $questions = $questions->concat($question);
        }

        $questions = $questions->map(function ($question) {
            return [
                'interval' => $question->questionable,
                'direction' => $question->direction,
                'type' => $question->type,
                'answer' => $question->answer,
                'date' => date('n', strtotime($question->created_at))
            ];
        });

        foreach ($intervalCollection as $interval) {
            $intervalData = $questions->filter(function ($question) use ($interval) {
                return $question['interval']->name === $interval;
            });
            $intervalCount = $intervalData->count();
            $correctIntervalCount = $intervalData->filter(function ($interval) {
                return $interval['answer'] === 1;
            })->count();
            $accuracy = null;
            if ($intervalCount) {
                $accuracy = $correctIntervalCount ? $correctIntervalCount * 100 / $intervalCount : 0;
            }

            $intervals->put($interval, [
                'amount' => $intervalCount,
                'accuracy' => $accuracy
            ]);
        }

        return Inertia::render('Front/Statistics/Index', [
            'questions' => $questions->values(),
            'intervals' => $intervals,
            'exercises' => $exercises->map(function ($exercise) {
                return [
                    'date' => date('n', strtotime($exercise->created_at))
                ];
            })->values()
        ]);
    }
}
