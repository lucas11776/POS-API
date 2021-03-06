<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string email
 * @property string token
 */
class PasswordReset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token'
    ];
}
