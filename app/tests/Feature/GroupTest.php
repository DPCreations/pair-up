<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_group()
    {
        $this->seed(UsersTableSeeder::class);

        Auth::login(User::first());

        $response = $this->post('/api/group', [
            'name' => 'My group',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('groups', [
            'name' => 'My group'
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_created_group()
    {
        $response = $this->post('/api/group', [
            'name' => 'My group',
        ]);

        $response->assertStatus(500);
        $this->assertDatabaseCount('groups', 0);x
    }

    /** @test */
    public function cannot_create_group_without_name()
    {
        $this->seed(UsersTableSeeder::class);

        Auth::login(User::first());

        $response = $this->post('/api/group');

        $response->assertStatus(302);
    }
}
