<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all()->map(function (Note $note) {
            return [
                'id' => $note->id,
                'name' => $note->name,
                'file' => $note->sound,
                'updated_at' => date('D m Y H:i', strtotime($note->updated_at)),
            ];
        });

        return Inertia::render('Admin/Notes/Index', [
            'notes' => $notes,
        ]);
    }

    public function edit(Note $note)
    {
        return Inertia::render('Admin/Notes/Edit', [
            'note' => [
                'id' => $note->id,
                'name' => $note->name,
                'file_path' => $note->file_path
            ]
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'file' => ['required', 'mimes:mp3'],
        ]);

        if ($request->file('file')) {
            $filePath = $request->file('file')->store('notes');
            $note->update(['sound' => $filePath]);
        }

        return redirect()->route('notes')->with('success', 'Note updated.');
    }
}
