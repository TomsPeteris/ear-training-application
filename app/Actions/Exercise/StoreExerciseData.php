<?php

namespace App\Actions\Exercise;

use App\Contracts\Exercise\StoresExerciseData;
use App\Models\Exercise;
use App\Models\Question;

class StoreExerciseData implements StoresExerciseData
{
    /**
     * Store exercise data in DB and return exercise object.
     *
     * @param array $input
     * @return Exercise
     */
    public function store(array $input): Exercise
    {
        $exercise = Exercise::create([
            'user_id' => request()->user()->id,
            'type' => $input['exercise_type'],
            'accuracy' => $input['accuracy']
        ]);

        foreach ($input['questions'] as $question) {
            Question::create([
                'questionable_type' => $question['questionable_type'],
                'questionable_id' => $question['questionable_id'],
                'answer' => $question['answer'],
                'direction' => $question['direction'],
                'type' => $question['type'],
                'exercise_id' => $exercise->id
            ]);
        }

        return $exercise;
    }
}
