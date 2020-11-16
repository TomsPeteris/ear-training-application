<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_member_user_is_not_an_admin()
    {
        $user = User::factory()->make([
            'role' => User::MEMBER_ROLE
        ]);

        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function an_admin_user_is_an_admin()
    {
        $user = User::factory()->make([
            'role' => User::ADMIN_ROLE
        ]);

        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function a_super_admin_user_is_an_admin()
    {
        $user = User::factory()->make([
            'role' => User::SUPER_ADMIN_ROLE
        ]);

        $this->assertTrue($user->isAdmin());
    }
}
