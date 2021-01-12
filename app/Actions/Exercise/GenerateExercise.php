<?php

namespace App\Actions\Exercise;

use App\Contracts\Exercise\GeneratesExercise;
use App\Models\Interval;
use App\Models\Note;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GenerateExercise implements GeneratesExercise
{
    /**
     * Function validates input data and creates exercise object
     * with execution parameters and questions.
     *
     * @param array $parameters
     * @return Collection
     * @throws ValidationException
     */
    public function generate(array $parameters): Collection
    {
        $validated = Validator::make($parameters, [
            'intervals' => ['required'],
            'direction' => ['required'],
            'type' => ['required'],
            'retry' => ['required'],
            'question_count' => ['required', 'integer', 'min:1', 'max:50']
        ])->validateWithBag('generateExercise');

        $questions = Collection::empty();

        for ($i = 0; $i < $validated['question_count']; $i++) {
            $questions->push($this->generateQuestion(
                $validated['intervals'],
                $validated['direction'],
                $validated['type'],
                $parameters['exercise_type']
            ));
        }

        $exerciseContent = Collection::empty();

        $exerciseContent->put('questions', $questions);
        $exerciseContent->put('retry', $validated['retry']);
        $exerciseContent->put('exercise_type', $parameters['exercise_type']);

        return $exerciseContent;
    }

    /**
     * Function generates question object based on exercise type.
     *
     * @param array $intervals
     * @param string $direction
     * @param string $playbackType
     * @param string $exerciseType
     * @return Collection
     */
    private function generateQuestion(array $intervals, string $direction, string $playbackType, string $exerciseType): Collection
    {
        $question = match ($exerciseType) {
            'interval' => Interval::where('name', array_rand(array_flip($intervals), 1))->first()
        };
        $questionClassString = get_class($question);
        $questionType = substr($questionClassString, strrpos($questionClassString, '\\') + 1);
        $questionContent = Collection::empty();

        $questionContent->put('questionable_type', $questionClassString);
        $questionContent->put('questionable_id', $question->id);
        $questionContent->put('direction', $direction);
        $questionContent->put('playback_type', $playbackType);
        $questionContent->put('sound', $this->getIntervalAudioFiles($question['distance']));
        $questionContent->put('answers', $this->generateAnswers($question->name, $questionType));
        $questionContent->put('correct_answer', $question->name);

        return $questionContent;
    }

    /**
     * Function generates 4 answer options based on question type.
     *
     * @param string $correctAnswer
     * @param string $questionType
     * @return array
     */
    private function generateAnswers(string $correctAnswer, string $questionType): array
    {
        $questionCollection = match ($questionType) {
            'Interval' => Interval::all(),
        };

        $answers = [$correctAnswer];

        for ($i = 1; $i < 4; $i++) {
            do {
                $answer = $questionCollection->random();
            } while (in_array($answer->name, $answers));

            array_push($answers, $answer->name);
        }

        shuffle($answers);

        return $answers;
    }

    /**
     * Function chooses a random starting note and builds the interval,
     * then retrieves the necessary sound file paths from DB.
     *
     * @param int $distance
     * @return array
     */
    private function getIntervalAudioFiles(int $distance): array
    {
        $notes = Note::all();
        $root = $notes->random();

        while ($root->id + $distance >= $notes->count() - 1) {
            $root = $notes->random();
        }

        return [
            'first' => $root->getAudioFilePath(),
            'second' => $notes->get($root->id + $distance - 1)->getAudioFilePath()
        ];
    }
}
