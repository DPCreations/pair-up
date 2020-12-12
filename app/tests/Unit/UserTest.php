<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\User;
use Database\Seeders\UserWithGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test owned groups relation is returning correct groups
     *
     * @return void
     */
    public function testOwnedGroupsIsReturned()
    {
        //Setup
        $this->seed(UserWithGroup::class);

        //Assert
        $this->assertCount(1, User::first()->ownedGroups);
    }

    public function testGroupsIsReturned()
    {
        //Setup
        $this->seed(UserWithGroup::class);

        //Assert
        $this->assertCount(1, User::first()->groups);
    }

    public function testGroupIsJoined()
    {
        //Setup
        $user = User::factory()->create();

        $group = Group::factory()->create([
            'user_id' => User::factory()->create()->id
        ]);

        //Act
        $user->joinGroup($group);
        
        //Assert
        $this->assertCount(1, $user->groups);
    }
}
