<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        $exercises = auth()->user()->exercises->map(function ($exercise) {
            return [
                'id' => $exercise->id,
                'type' => $exercise->type,
                'accuracy' => $exercise->accuracy,
                'created_at' => date('D m Y H:i', strtotime($exercise->created_at))
            ];
        });

        return Inertia::render('Front/History/Index', [
            'exercises' => $exercises
        ]);
    }
}
