<?php

namespace App\Http\Controllers\Front;

use App\Contracts\Exercise\GeneratesExercise;
use App\Contracts\Exercise\StoresExerciseData;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Interval;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class ExerciseController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Front/Exercises/Index', [
            'exercises' => Exercise::TYPES,
        ]);
    }

    /**
     * @return InertiaResponse
     */
    public function interval(): InertiaResponse
    {
        return Inertia::render('Front/Exercises/Interval', [
            'type' => Exercise::INTERVAL_TYPE,
            'intervals' => Interval::all(),
        ]);
    }

    /**
     * @param Request $request
     * @param GeneratesExercise $generator
     * @return InertiaResponse
     */
    public function execute(Request $request, GeneratesExercise $generator): InertiaResponse
    {
        $exercise = $generator->generate($request->all());

        return Inertia::render('Front/Exercises/Exercise', [
            'questions' => $exercise['questions'],
            'retry' => $exercise['retry'],
            'exerciseType' => $exercise['exercise_type']
        ]);
    }

    /**
     * @param Request $request
     * @param StoresExerciseData $storer
     * @return RedirectResponse
     */
    public function store(Request $request, StoresExerciseData $storer): RedirectResponse
    {
        $exercise = $storer->store($request->all());

        return redirect()->route('history.overview', $exercise->id);
    }
}
