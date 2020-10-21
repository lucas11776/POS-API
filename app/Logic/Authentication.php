<?php

namespace App\Logic;

use App\User;
use Illuminate\Support\Facades\Hash;

class Authentication implements AuthenticationInterface
{
    /**
     * Number of seconds in a day.
     *
     * @var integer
     */
    public const SECONDS_IN_DAY = 86400;

    /**
     * Number of seconds in a year.
     *
     * @var integer
     */
    public const SECONDS_IN_YEAR = 31536000;

    public function register(array $form): User
    {
        $user = $this->create($form);
        $user->image = $user->image()
            ->create(['url' => url(User::DEFAULT_PROFILE_PICTURE)]);
        return $user;
    }

    public function login(array $credentials)
    {
        // TODO: Implement login() method.
    }

    public function respond_with_token(User $user, bool $stay_logged_in = false): array
    {
        return [
            'token' => $this->user_to_token($user, $stay_logged_in),
            'expire' => $stay_logged_in ? self::SECONDS_IN_YEAR : self::SECONDS_IN_DAY,
            'type' => 'Bearer'
        ];
    }

    protected function create(array $form): User
    {
        return User::create([
            'first_name' => $form['first_name'],
            'last_name' => $form['last_name'],
            'gender' => isset($form['gender']) ? $form['gender'] : null,
            'email' => isset($form['email']) ? $form['email'] : null,
            'cellphone_number' => isset($form['cellphone_number']) ? $form['cellphone_number'] : null,
            'password' => Hash::make($form['password'])
        ]);
    }

    protected function user_to_token(User $user, bool $stay_logged_in): string
    {
        return auth('api')->setTTL($stay_logged_in ? self::SECONDS_IN_YEAR : self::SECONDS_IN_DAY)
            ->login($user);
    }
}
