<?php

namespace App\Actions\User;

use App\Contracts\User\CreatesUser;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateUser implements CreatesUser
{
    /**
     * Validate input and create an user based on it.
     *
     * @param array $input
     * @return void
     * @throws ValidationException
     */
    public function create(array $input)
    {
        $validated = Validator::make($input, [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'max:255', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image'],
            'role' => ['required'],
        ])->validateWithBag('createUser');

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'avatar' => $validated['avatar'] !== null
                ? $validated['avatar']->store('avatars')
                : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
