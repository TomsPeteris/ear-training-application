<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateProfilePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function current_password_must_match_current_user_password()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => Hash::make('12345678'),
            'role' => 'Member'
        ]);

        $attributes = [
            'current_password' => '123456789',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasErrorsIn('updatePassword', ['current_password']);

        $attributes['current_password'] = '12345678';

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_and_confirm_password_must_match()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => Hash::make('12345678'),
            'role' => 'Member'
        ]);

        $attributes = [
            'current_password' => '12345678',
            'password' => '1234567890',
            'password_confirmation' => '123456789',
        ];

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasErrorsIn('updatePassword', ['password']);

        $attributes['password'] = $attributes['password_confirmation'];

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_cannot_contain_less_than_min__number_of_characters()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => Hash::make('12345678'),
            'role' => 'Member'
        ]);

        $attributes = [
            'current_password' => '12345678',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ];

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasErrorsIn('updatePassword', ['password']);

        $attributes['password'] = '12345678';
        $attributes['password_confirmation'] = '12345678';

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_cannot_contain_more_than_max_number_of_character()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => Hash::make('12345678'),
            'role' => 'Member'
        ]);

        $attributes = [
            'current_password' => '12345678',
            'password' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ11',
            'password_confirmation' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ1',
            'role' => 'Member'
        ];

        // 256 characters
        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasErrorsIn('updatePassword', ['password']);

        $attributes['password'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';
        $attributes['password_confirmation'] = $attributes['password'];

        // 255 characters
        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function current_password_field_is_required()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => Hash::make('12345678'),
            'role' => 'Member'
        ]);

        $attributes = [
            'current_password' => '123456789',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasErrorsIn('updatePassword', ['current_password']);

        $attributes['current_password'] = '12345678';

        $this->actingAs($user)
            ->put(route('profile.update-password', $attributes))
            ->assertSessionHasNoErrors();
    }

}
