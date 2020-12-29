<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer user_id
 * @property integer role_id
 */
class UsersRoles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'role_id'
    ];
}
