<?php

namespace App\Contracts\Note;

use App\Models\Note;

interface UpdatesNote
{
    /**
     * Validate input and update the given note.
     *
     * @param Note $note
     * @param  array  $input
     * @return void
     */
    public function update(Note $note, array $input);
}
