<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Note\UpdatesNote;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class NoteController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        $notes = Note::paginate(8)
            ->only('id', 'name', 'sound', 'updated_at')
            ->transform(function ($item) {
               return [
                   'id' => $item['id'],
                   'name' => $item['name'],
                   'file' => $item['sound'],
                   'updated_at' => date('D m Y H:i', strtotime($item['updated_at']))
               ];
            });


        return Inertia::render('Admin/Notes/Index', [
            'notes' => $notes,
        ]);
    }

    /**
     * @param Note $note
     * @return InertiaResponse
     */
    public function edit(Note $note): InertiaResponse
    {
        return Inertia::render('Admin/Notes/Edit', [
            'note' => [
                'id' => $note->id,
                'name' => $note->name,
                'file_path' => $note->getAudioFilePath()
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param UpdatesNote $updater
     * @param Note $note
     * @return RedirectResponse
     */
    public function update(Request $request, UpdatesNote $updater, Note $note): RedirectResponse
    {
        $updater->update($note, $request->all());

        return redirect()->route('notes')->with('success', 'Note updated.');
    }
}
