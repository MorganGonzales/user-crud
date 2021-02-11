<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithFaker;

    const USERS_TABLE = 'users';

    /**
     * @var UserServiceInterface
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->service = app(UserServiceInterface::class);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_users()
    {
        // Arrangements
        User::factory()->count(20)->create();

        // Actions
        $userList = $this->service->list();

        // Assertions
        $this->assertInstanceOf(LengthAwarePaginator::class, $userList);
        $this->assertCount(5, $userList->items());
        $this->assertDatabaseCount(self::USERS_TABLE, 20);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_store_a_user_to_database()
    {
        // Arrangements
        $attributes = [
            'firstname' => 'Morgan',
            'lastname' => 'Gonzales',
            'username' => 'Morgy',
            'email' => 'email@example.com',
            'password' => 'sample-password',
        ];

        // Actions
        $user = $this->service->store($attributes);

        // Assertions
        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas(self::USERS_TABLE, $attributes);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_find_and_return_an_existing_user()
    {
        // Arrangements
        $newUser = User::factory()->make();
        $newUser->save();

        // Actions
        $userFromDb = $this->service->find($newUser->id);

        // Assertions
        $this->assertTrue($newUser->is($userFromDb));
        $this->assertInstanceOf(User::class, $userFromDb);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_update_an_existing_user()
    {
        // Arrangements
        $old = User::factory()->create();
        $attributes = [
            'firstname' => 'Spongebob',
            'lastname' => 'Squarepants',
            'username' => 'Morgy',
        ];

        // Actions
        $updateResult = $this->service->update($old->id, $attributes);

        // Assertions
        $this->assertTrue($updateResult);
        $this->assertDatabaseHas(self::USERS_TABLE, [
            'firstname' => 'Spongebob',
            'lastname' => 'Squarepants',
            'username' => 'Morgy',
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_soft_delete_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $deleteResult = $this->service->delete($user->id);

        // Assertions
        $this->assertTrue($deleteResult);
        $this->assertSoftDeleted($user);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
        // Arrangements
        User::factory()->count(20)->create(['deleted_at' => now()]);

        // Actions
        $users = $this->service->listTrashed();

        // Assertions
        $this->assertDatabaseCount(self::USERS_TABLE, 20);
        $this->assertCount(5, $users->items());
    }

    /**
     * @test
     * @return void
     */
    public function it_can_restore_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create(['deleted_at' => now()]);

        // Actions
        $restoreResult = $this->service->restore($user->id);

        // Assertions
        $this->assertTrue($restoreResult);
        $this->assertDatabaseMissing(self::USERS_TABLE, ['deleted_at' => $user->deleted_at]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create(['deleted_at' => now()]);

        // Actions
        $destroyResult = $this->service->destroy($user->id);

        // Assertions
        $this->assertTrue($destroyResult);
        $this->assertDatabaseMissing(self::USERS_TABLE, ['id' => $user->id]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_upload_photo()
    {
        // Arrangements
        $file = UploadedFile::fake()->image($fileName = 'something-awesome.jpg');

        // Actions
        $storagePath = $this->service->upload($file);

        // Assertions
        $this->assertEquals("/storage/avatars/{$fileName}", $storagePath);
    }
}