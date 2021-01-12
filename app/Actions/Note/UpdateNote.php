<?php

namespace App\Actions\Note;

use App\Contracts\Note\UpdatesNote;
use App\Models\Note;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateNote implements UpdatesNote
{
    /**
     * Validate input and update the given note.
     *
     * @param Note $note
     * @param array $input
     * @return void
     * @throws ValidationException
     */
    public function update(Note $note, array $input)
    {
        $validated = Validator::make($input, [
            'file' => ['required', 'mimes:mp3,wav'],
        ])->validateWithBag('updateNote');

        $filePath = $validated['file']->store('notes');
        $note->update(['sound' => $filePath]);
    }
}
