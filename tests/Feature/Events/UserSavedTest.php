<?php

namespace Tests\Feature\Events;

use App\Events\UserSaved;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserSavedTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_dispatches_the_user_saved_event_when_user_is_created()
    {
        Event::fake();

        $authUser = User::factory()->create();
        $newUser = [
            'firstname' => 'Patrick',
            'lastname' => 'Starfish',
            'username' => 'Pat',
            'email' => 'patrick.starfish@bikinibottom.net',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->actingAs($authUser)->post(route('users.store'), $newUser);

        Event::assertDispatched(function (UserSaved $event) use ($newUser) {
            return $event->user->username === $newUser['username'];
        });
    }

    /**
     * @test
     * @return void
     */
    public function it_dispatches_the_user_saved_event_when_user_is_updated()
    {
        Event::fake();

        $user = User::factory()->create();
        $data = [
            'firstname' => 'Patrick',
            'lastname' => 'Star',
            'username' => 'Pat',
            'email' => 'patrick.starfish@bikinibottom.net',
        ];

        $this->actingAs($user)->post(route('users.update', $user->id), $data);

        Event::assertDispatched(function (UserSaved $event) use ($user) {
            return $event->user->username === $user->username;
        });
    }
}
