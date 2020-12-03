<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        $exercises = Exercise::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($exercise) {
                return [
                    'id' => $exercise->id,
                    'type' => $exercise->type,
                    'accuracy' => $exercise->accuracy,
                    'date' => date('d.m.Y', strtotime($exercise->created_at)),
                ];
            });

        return Inertia::render('Front/History/Index', [
            'exercises' => $exercises
        ]);
    }
}
