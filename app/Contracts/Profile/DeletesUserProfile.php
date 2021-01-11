<?php

namespace App\Contracts\Profile;

use App\Models\User;

interface DeletesUserProfile
{
    /**
     * Validate password and delete the given user's profile.
     *
     * @param  User  $user
     * @param  array  $input
     * @return void
     */
    public function delete(User $user, array $input);
}
