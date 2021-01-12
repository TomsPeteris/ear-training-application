<?php

namespace App\Contracts\User;

interface CreatesUser
{
    /**
     * Validate input un store the user in DB.
     *
     * @param  array  $input
     * @return void
     */
    public function create(array $input);
}
