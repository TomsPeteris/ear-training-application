<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_non_admin_can_not_access_the_admin_panel()
    {
        $this->actingAs(User::factory()->make(['role' => User::MEMBER_ROLE]))
            ->get(route('admin'))
            ->assertForbidden();
    }

   /** @test */
    public function an_admin_can_access_the_admin_panel()
    {
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->get(route('admin'))
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_access_users()
    {
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->get(route('users'))
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_access_the_user_creation_form()
    {
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->get(route('users.create'))
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_create_users()
    {
        $user = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'Member',
            'avatar' => '',
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store'), $user)
            ->assertRedirect(route('users'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => $user['email']
        ]);
    }

    /** @test */
    public function an_admin_can_access_edit_user_form()
    {
        $user = User::factory()->create(['role' => User::MEMBER_ROLE]);

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->get(route('users.edit', $user->id))
            ->assertOk();
    }

    /** @test */
    public function an_super_admin_can_update_users()
    {
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'Member',
            'avatar' => '',
        ]);

        $attributes = [
            'role' => 'Admin'
        ];

        $this->actingAs(User::factory()->make(['role' => User::SUPER_ADMIN_ROLE]))
            ->put(route('users.update', $user->id), $attributes)
            ->assertRedirect(route('users'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', $attributes);
    }

    /** @test */
    public function an_admin_can_delete_users()
    {
        $this->withoutExceptionHandling();
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'Member',
            'avatar' => '',
        ]);

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->delete(route('users.destroy', $user->id))
            ->assertRedirect(route('users'))
            ->assertSessionHas('success');

        $this->assertDeleted('users', [
            'email' => $user->email
        ]);
    }

    /** @test */
    public function an_admin_can_access_notes()
    {
        $this->withoutExceptionHandling();
        Note::factory()->count(10)->create();

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->get(route('notes'))
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_access_edit_notes_form()
    {
        $note = Note::factory()->create();
        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->get(route('notes.edit', $note->id))
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_update_notes()
    {
        $note = Note::factory()->create();
        $file = UploadedFile::fake()->image('note.mp3');
        $sound = $note->sound;

        $this->assertDatabaseHas('notes', [
            'sound' => $sound
        ]);

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('notes.update', $note->id), [
                'file' => $file
            ])
            ->assertRedirect(route('notes'))
            ->assertSessionHas('success');

        $note->refresh();

        $this->assertTrue($note->sound !== $sound);
    }
}
