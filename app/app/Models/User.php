<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Boolean;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The groups in which the user is participating
     *
     * @return HasManyThrough
     */
    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(Group::class, UserGroup::class, 'group_id', 'id', 'id', 'user_id');
    }

    /**
     * The groups owned by the user
     *
     * @return HasMany
     */
    public function ownedGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'user_id', 'id');
    }

    /**
     * Join a given group
     *
     * @param Group $group
     * @return UserGroup
     */
    public function joinGroup(Group $group): UserGroup
    {
        return UserGroup::firstOrCreate([
            'user_id' => $this->id,
            'group_id' => $group->id
        ]);
    }


}
