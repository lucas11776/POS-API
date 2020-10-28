<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Maximum image size allowed.
     *
     * @var integer
     */
    public const MAX_IMAGE_SIZE = 1024 * 3;

    public const ALLOWED_MIME_TYPES = [
        'jpeg', 'png'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'url'
    ];
}
