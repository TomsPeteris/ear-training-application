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
        $user = User::factory()->raw(['role' => User::MEMBER_ROLE]);

        $user['password_confirmation'] = $user['password'];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->post(route('users.store'), $user)
            ->assertRedirect(route('users'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => $user['username'],
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
    public function an_admin_can_update_users()
    {
        $user = User::factory()->create(['role' => User::MEMBER_ROLE]);

        $attributes = [
            'username' => 'NewUsername',
            'full_name' => 'Updated Full Name',
            'email' => 'updated@email.com'
        ];

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->put(route('users.update', $user->id), $attributes)
            ->assertRedirect(route('users'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', $attributes);
    }

    /** @test */
    public function an_admin_can_delete_users()
    {
        $user = User::factory()->create(['role' => User::MEMBER_ROLE]);

        $this->actingAs(User::factory()->make(['role' => User::ADMIN_ROLE]))
            ->delete(route('users.destroy', $user->id))
            ->assertRedirect(route('users'))
            ->assertSessionHas('success');

        $this->assertDeleted('users', [
            'username' => $user->username,
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
