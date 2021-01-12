<?php

namespace App\Providers;

use App\Actions\User\DeleteUser;
use App\Actions\User\CreateUser;
use App\Actions\User\UpdateUser;
use App\Services\User;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
        User::storeUserUsing(CreateUser::class);
        User::updateUserUsing(UpdateUser::class);
        User::deleteUserUsing(DeleteUser::class);
    }
}
