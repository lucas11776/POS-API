<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property Image image
 * @property string first_name
 * @property string last_name
 * @property string gender
 * @property string email
 * @property string cellphone_number
 * @property string description
 * @property Address address
 * @property Collection roles
 */
class User extends Authenticatable implements JWTSubject
{
    /**
     * Default user profile picture.
     *
     * @var string
     */
    public const DEFAULT_PROFILE_PICTURE = 'assets/default/profile-picture.png';

    /**
     * Profile picture storage.
     *
     * @var string
     */
    public const PROFILE_PICTURE_STORAGE = 'avatars';

    /**
     * Types of gender.
     *
     * @var array
     */
    public const GENDER = ['female', 'male'];

    /**
     * Default user password for testing.
     *
     * @var string
     */
    public const DEFAULT_PASSWORD = 'Test@123';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'country_id', 'gender', 'email', 'cellphone_number', 'description', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'cellphone_number_verified_at' => 'datetime'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
    ];

    use Notifiable;

    /**
     * User profile picture image.
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->orderBy('id', 'DESC');
    }

    /**
     * User address.
     *
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get roles that belong to the user.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, UsersRoles::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
