<?php

namespace App\Providers;

use App\Actions\Profile\DeleteUserProfile;
use App\Services\Profile;
use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
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
        Profile::deleteUserProfileUsing(DeleteUserProfile::class);
    }
}
