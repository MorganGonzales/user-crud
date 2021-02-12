<?php

namespace Tests\Feature\Listeners;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaveUserBackgroundInformationTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_saves_the_user_detail_when_a_user_is_created()
    {
        $newUser = User::factory()->make(['username' => $username = 'boom.beybe']);
        $password = ['password' => 'password', 'password_confirmation' => 'password'];

        $this
            ->actingAs(User::factory()->create())
            ->post(route('users.store'), $newUser->toArray() + $password)
            ->assertRedirect(route('users.index'));

        $createdUser = User::where('username', $username)->first();

        $this->assertEquals($username, $createdUser->username);
        $this->assertNotEmpty($createdUser->details);
        $this->assertDatabaseHas('details', ['value' => $createdUser->fullname, 'user_id' => $createdUser->id]);
    }

    /**
     * @test
     * @return void
     */
    public function it_saves_the_user_detail_when_a_user_is_updated()
    {
        $user = User::factory()->create(['prefixname' => 'Mr.', 'middlename' => '', 'suffixname' => '']);
        $this->assertNotEmpty($user->details);

        $data = [
            'firstname' => 'Spongebob',
            'lastname' => 'Squarepants',
            'username' => 'Spongy',
            'email' => 'spongebob.squarepants@bikinibottom.net'
        ];

        $this
            ->actingAs($user)
            ->put(route('users.update', $user->id), $data)
            ->assertRedirect(route('users.index'));

        $this->assertNotEmpty($user->details);
        $this->assertDatabaseHas('details', ['value' => 'Spongebob Squarepants', 'user_id' => $user->id]);
        $this->assertDatabaseHas('details', ['value' => 'Male', 'user_id' => $user->id]);
    }
}
