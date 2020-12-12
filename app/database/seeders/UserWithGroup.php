<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class UserWithGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();

        $group = Group::factory()->create([
            'name' => 'My group',
            'user_id' => $user->id
        ]);

        UserGroup::factory()->create([
            'user_id' => $user->id,
            'group_id' => $group->id
        ]);
    }
}
