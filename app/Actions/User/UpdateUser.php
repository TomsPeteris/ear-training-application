<?php

namespace App\Actions\User;

use App\Contracts\User\UpdatesUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateUser implements UpdatesUser
{
    /**
     * Validate input and update the given user.
     *
     * @param User $user
     * @param array $input
     * @return void
     * @throws ValidationException
     */
    public function update(User $user, array $input)
    {
        $validated = Validator::make($input, [
            'role' => ['required'],
        ])->validateWithBag('updateUser');

        if ($user->role !== $validated['role']) {
            $user->update($validated);
        }
    }
}
