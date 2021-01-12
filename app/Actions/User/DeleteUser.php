<?php

namespace App\Actions\User;

use App\Contracts\User\DeletesUser;
use App\Models\User;
use Exception;

class DeleteUser implements DeletesUser
{
    /**
     * Delete the given user.
     *
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function delete(User $user)
    {
        $user->delete();
    }
}
