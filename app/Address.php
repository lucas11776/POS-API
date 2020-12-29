<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string address
 * @property string country
 * @property string city
 * @property string postal_code
 */
class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'country', 'city', 'postal_code'
    ];
}
