<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_can_show_the_list_of_users()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('users.index'))
            ->assertStatus(200)
            ->assertSee('User List (Active)')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_show_the_create_user_page()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('users.create'))
            ->assertStatus(200)
            ->assertSee('Add User')
            ->assertSee('Password')
            ->assertSee('Confirm Password')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_create_a_user()
    {
        $data = [
            'firstname' => 'Patrick',
            'lastname' => 'Starfish',
            'username' => 'Pat',
            'email' => 'patrick.starfish@bikinibottom.net',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('users.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('success', 'User created successfully.')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_show_the_list_of_deleted_users()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('users.trashed'))
            ->assertStatus(200)
            ->assertSee('User List (Deleted)')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_show_the_display_user_page()
    {
        $user = User::factory()->create([
            'firstname' => 'Squidward',
            'lastname' => 'Tentacles',
            'username' => 'Handsome',
        ]);

        $this
            ->actingAs($user)
            ->get(route('users.show', $user->id))
            ->assertStatus(200)
            ->assertSee('Squidward')
            ->assertSee('Tentacles')
            ->assertSee('Handsome')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_show_the_update_user_page()
    {
        $user = User::factory()->create([
            'firstname' => 'Sandy',
            'lastname' => 'Cheeks',
        ]);

        $this
            ->actingAs($user)
            ->get(route('users.edit', $user->id))
            ->assertStatus(200)
            ->assertSee('Update User')
            ->assertSee('Sandy')
            ->assertSee('Cheeks')
            ->assertDontSee('Password')
            ->assertDontSee('Confirm Password')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_update_a_user()
    {
        $data = [
            'firstname' => 'Patrick',
            'lastname' => 'Star',
            'username' => 'Pat',
            'email' => 'patrick.starfish@bikinibottom.net',
        ];
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->put(route('users.update', $user->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('success', 'User updated successfully.')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_soft_delete_a_user()
    {
        $user = User::factory()->count(2)->create();

        $userName = $user->last()->username;

        $this
            ->actingAs($user->first())
            ->delete(route('users.delete', $user->last()->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'))
            ->assertDontSee($userName)
            ->assertSessionHas('success', 'User temporarily deleted successfully.')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_restore_a_user()
    {
        $user = User::factory()->create();
        $deletedUser = User::factory()->create(['deleted_at' => now()]);

        $this
            ->actingAs($user->first())
            ->patch(route('users.restore', $deletedUser->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.trashed'))
            ->assertDontSee($deletedUser->username)
            ->assertSessionHas('success', 'User restored successfully.')
        ;
    }

    /**
     * @test
     * @return void
     */
    public function it_can_permanent_delete_a_user()
    {
        $user = User::factory()->create();
        $deletedUser = User::factory()->create(['deleted_at' => now()]);

        $this
            ->actingAs($user->first())
            ->delete(route('users.destroy', $deletedUser->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.trashed'))
            ->assertSessionHas('success', 'User permanently deleted successfully.')
        ;
    }
}
