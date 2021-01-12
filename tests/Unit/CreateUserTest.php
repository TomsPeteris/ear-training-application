<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function first_name_field_is_required()
    {
        $attributes = [
            'last_name' => 'Test',
            'email' => 'test@case.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' =>'Member'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['first_name']);

        $attributes += array('first_name' => 'Case');

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function last_name_field_is_required()
    {
        $attributes = [
            'first_name' => 'Test Case',
            'email' => 'test@case.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' =>'Member'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['last_name']);

        $attributes += array('last_name' => 'Case');

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function email_field_is_required()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' =>'Member'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['email']);

        $attributes += array('email' => 'test@case.com');

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_and_confirm_password_must_match()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => '12345678',
            'password_confirmation' => '1234567',
            'role' => 'Member'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['password']);

        $attributes['password_confirmation'] = '12345678';

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function cant_enter_more_than_max_number_characters_in_first_name_field()
    {
        $attributes = [
            'first_name' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJE',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'Member'
        ];

        // 256 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['first_name']);

        $attributes['first_name'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';

        // 255 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function cant_enter_more_than_max_number_characters_in_last_name_field()
    {

        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJE',
            'email' => 'test@case.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'Member'
        ];

        // 256 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['last_name']);

        $attributes['last_name'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';

        // 255 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function email_must_have_email_structure()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'testcase.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'Member'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['email']);

        $attributes['email'] = 'test@case.com';

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_cannot_contain_less_than_min__number_of_characters()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
            'role' => 'Member'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['password']);

        $attributes['password'] = '12345678';
        $attributes['password_confirmation'] = '12345678';

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_cannot_contain_more_than_max_number_of_character()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'test@case.com',
            'password' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJE',
            'password_confirmation' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJE',
            'role' => 'Member'
        ];

        // 256 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasErrorsIn('createUser', ['password']);

        $attributes['password'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';
        $attributes['password_confirmation'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';

        // 255 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store', $attributes))
            ->assertSessionHasNoErrors();
    }
}
