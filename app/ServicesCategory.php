<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicesCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url'
    ];

    /**
     * Get services that belong to the catgory.
     *
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(ServicesCategory::class);
    }
}
