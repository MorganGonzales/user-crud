<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    const TABLE = 'users';

    /**
     * @test
     * @return void
     */
    public function it_has_expected_users_table_columns()
    {
        $columns = [
            'id',
            'prefixname',
            'firstname',
            'middlename',
            'lastname',
            'suffixname',
            'username',
            'email',
            'password',
            'photo',
            'type',
            'remember_token',
            'email_verified_at',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        $this->assertTrue(Schema::hasColumns(self::TABLE, $columns));
        $this->assertEquals($columns, Schema::getColumnListing(self::TABLE));
    }
}
