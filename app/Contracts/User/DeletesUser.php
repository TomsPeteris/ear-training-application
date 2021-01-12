<?php

namespace App\Contracts\User;

use App\Models\User;

interface DeletesUser
{
    /**
     * Delete the given user.
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user);
}
