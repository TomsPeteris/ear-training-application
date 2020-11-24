<?php

namespace App\Services;

use App\Models\Interval;
use App\Models\Note;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;

class ExerciseGenerator
{
    /**
     * @param Collection $attributes
     * @return Collection
     */
    public function generateExercise($attributes)
    {
        $exerciseContent = $attributes;
        $questions = Collection::empty();

        for ($i = 0; $i < $exerciseContent['count']; $i++) {
            $questions->push($this->generateQuestion($exerciseContent->only('question_attributes')));
        }
        $exerciseContent->forget('question_attributes');
        $exerciseContent->put('questions', $questions);

        return $exerciseContent;
    }

    /**
     * @param Collection $attributes
     * @return Collection
     */
    public function generateQuestion($attributes)
    {
        $interval = $attributes['question_attributes']['intervals']->random();
        $question = Collection::empty();

        $question->put('questionable_type', get_class($interval));
        $question->put('questionable_id', $interval->id);
        $question->put('direction', $attributes['question_attributes']['direction']);
        $question->put('type', $attributes['question_attributes']['type']);
        $question->put('sound', $this->getSoundFiles($interval['distance'], $question['direction']));
        $question->put('answers', $this->generateAnswers($interval->name));

        return $question;
    }

    /**
     * @param String
     * @return array
     */
    public function generateAnswers($interval)
    {
        $intervals = Note::all();
        $answers = [$interval];

        for ($i = 1; $i < 4; $i++) {
            do {
                $answer = $intervals->random();
            } while (in_array($answer, $answers));

            array_push($answers, $intervals->random()->name);
        }

        shuffle($answers);

        return $answers;
    }

    /**
     * @param Integer $distance
     * @param String_ $direction
     * @return array
     */
    public function getSoundFiles($distance, $direction)
    {
        $notes = Note::all();
        $root = $notes->random();

        if ($direction === Interval::ASCENDING_DIRECTION) {
            while ($root->id + $distance >= $notes->count() - 1) {
                $root = $notes->random();
            }
        } else {
            while ($root->id - $distance <= 0) {
                $root = $notes->random();
            }
        }

        return [
            'root' => $root->getSoundPath(),
            'end' => $notes->get($root->id + $distance)->getSoundPath()
        ];
    }
}
