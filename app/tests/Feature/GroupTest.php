<?php

namespace Tests\Feature;

use App\Models\{Group, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    private $payload = [
        'name' => 'My group',
    ];

    /** @test */
    public function authenticated_user_can_create_group()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/group', $this->payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('groups', $this->payload);
        $this->assertDatabaseHas('user_groups', [
            'user_id' => $user->id,
            'group_id' => Group::first()->id
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_created_group()
    {
        $response = $this->post('/api/group', $this->payload);

        $response->assertStatus(302);
        $this->assertDatabaseCount('groups', 0);
    }

    /** @test */
    public function cannot_create_group_without_name()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/group');

        $response->assertStatus(302);
    }
}
