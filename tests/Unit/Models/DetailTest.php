<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DetailTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    const TABLE = 'details';

    /**
     * @test
     * @return void
     */
    public function it_has_expected_users_table_columns()
    {
        $columns = [
            'id',
            'key',
            'value',
            'icon',
            'status',
            'type',
            'user_id',
            'created_at',
            'updated_at',
        ];

        $this->assertTrue(Schema::hasColumns(self::TABLE, $columns));
        $this->assertEquals($columns, Schema::getColumnListing(self::TABLE));
    }
}
