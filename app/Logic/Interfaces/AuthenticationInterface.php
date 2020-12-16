<?php

namespace App\Logic\Interfaces;

use App\User;

interface AuthenticationInterface
{
    /**
     * Register new user account in the database.
     *
     * @param array $form
     * @return User
     */
    public function register(array $form): User;

    /**
     * Validate credentials and return user entity.
     *
     * @param array $credentials
     * @return mixed
     */
    public function login(array $credentials);

    /**
     * Logout user.
     */
    public function logout(): void;

    /**
     * Convert user entity to jwt.
     *
     * @param User $user
     * @param bool $stay_logged_in
     * @return mixed
     */
    public function respond_with_token(User $user, bool $stay_logged_in = false): array;
}
