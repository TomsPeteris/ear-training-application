<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function first_name_field_is_required()
    {
        $attributes = [
            'last_name' => 'Test',
            'email' => 'test@case.com',
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['first_name']);

        $attributes += array('first_name' => 'Case');

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function last_name_field_is_required()
    {
        $attributes = [
            'first_name' => 'Test Case',
            'email' => 'test@case.com',
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['last_name']);

        $attributes += array('last_name' => 'Case');

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function email_field_is_required()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['email']);

        $attributes += array('email' => 'test@case.com');

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function email_must_have_email_structure()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'testcase.com',
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['email']);

        $attributes['email'] = 'test@case.com';

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function cant_enter_more_than_max_number_characters_in_first_name_field()
    {
        $attributes = [
            'first_name' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJE',
            'last_name' => 'Case',
            'email' => 'test@case.com',
        ];

        // 256 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['first_name']);

        $attributes['first_name'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';

        // 255 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function cant_enter_more_than_max_number_characters_in_last_name_field()
    {

        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJE',
            'email' => 'test@case.com',
        ];

        // 256 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['last_name']);

        $attributes['last_name'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSNBd6TDJ';

        // 255 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function cant_enter_more_than_max_number_characters_in_email_field()
    {
        $attributes = [
            'first_name' => 'Test',
            'last_name' => 'Case',
            'email' => 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanSN@tim.com',
        ];

        // 256 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasErrorsIn('updateProfileInformation', ['email']);

        $attributes['email'] = 'UETblRUvfLflQPq8darAk0X4WzZR42QN6a17IsPt9ORhWYHSocPoq2dFcyzo1KIcLBzxgJEXloz6iON0lqpXBz27PLfgcM5yGR0Fc9X8aDq0ilhTB7GzFKNt9kENmltfbvoK4h9LPrwL69Y81qauwUcWnzJEJDwmzqLAqGec4h3tJij4fVIfLUUiULLsGqiFXBTlg79DXX0G0ah19wPuBN2daWnpI1ZSZ5OM6ISzz2zLhwaJ8IM0yanS@ti.com';

        // 255 characters
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('profile.update-information', $attributes))
            ->assertSessionHasNoErrors();
    }
}
