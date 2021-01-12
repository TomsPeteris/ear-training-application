<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function password_must_match_authenticated_user_password()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => Hash::make('12345678'),
            'role' => 'Member'
        ]);

        $attributes = [
            'password' => '1234567891',
        ];

        $this->actingAs($user)
            ->delete(route('profile.delete', $attributes))
            ->assertSessionHasErrorsIn('deleteUser', ['password']);

        $attributes['password'] = '12345678';

        $this->actingAs($user)
            ->delete(route('profile.delete', $attributes))
            ->assertSessionHasNoErrors();
    }
}
