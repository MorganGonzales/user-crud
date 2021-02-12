<?php

namespace Tests\Unit\Listeners;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SaveUserBackgroundInformationTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    protected SaveUserBackgroundInformation $listener;

    public function setUp(): void
    {
        parent::setUp();

        $this->listener = $this->app->make(SaveUserBackgroundInformation::class);
    }

    /**
     * @test
     */
    public function it_can_handle_saving_of_details_of_a_given_user()
    {
        Event::fake();

        $user = User::factory()->create(['photo' => 'sample-image.jpg']);
        $this->assertEmpty($user->details);

        $event = \Mockery::mock(UserSaved::class);
        $event->user = $user;

        $listener = app()->make(SaveUserBackgroundInformation::class);
        $listener->handle($event);
        $user->refresh();

        $this->assertNotEmpty($user->details);
        $this->assertCount(4, $user->details);
        $this->assertDatabaseHas('details', ['value' => $user->fullname, 'user_id' => $user->id]);
        $this->assertDatabaseHas('details', ['value' => $user->middleinitial, 'user_id' => $user->id]);
        $this->assertDatabaseHas('details', ['value' => asset($user->photo), 'user_id' => $user->id]);
        $this->assertDatabaseHas('details', ['value' => $user->gender, 'user_id' => $user->id]);
    }
}
