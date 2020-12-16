<?php

namespace App\Logic\Interfaces;

use App\User;

interface UsersInterface
{
    /**
     * Get user account.
     *
     * @param int $id
     * @return User
     */
    public function account(int $id): User;
}
