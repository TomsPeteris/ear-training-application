<?php

namespace App\Providers;

use App\Actions\Note\UpdateNote;
use App\Services\Note;
use Illuminate\Support\ServiceProvider;

class NoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Note::updateNoteUser(UpdateNote::class);
    }
}
