<?php

namespace App\Actions\Profile;

use App\Contracts\Profile\DeletesUserProfile;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUserProfile implements DeletesUserProfile
{
    /**
     * @var StatefulGuard
     */
    protected $auth;

    /**
     * DeleteUserProfile constructor.
     * @param StatefulGuard $auth
     */
    public function __construct(StatefulGuard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param mixed $user
     * @param array $input
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete($user, array $input)
    {
        if (! Hash::check($input['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ])->errorBag('deleteUser');
        }

        auth()->logout();

        $user->delete();
    }
}
