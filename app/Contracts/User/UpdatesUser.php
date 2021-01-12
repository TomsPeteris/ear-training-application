<?php

namespace App\Contracts\User;

use App\Models\User;

interface UpdatesUser
{
    /**
     * Validate input and update the given user.
     *
     * @param  User  $user
     * @param  array  $input
     * @return void
     */
    public function update(User $user, array $input);
}
