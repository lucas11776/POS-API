<?php

namespace App\Logic\Interfaces;

use App\Role;
use App\User;

interface UserInterface
{
    /**
     * Get user with address and image.
     *
     * @return User
     */
    public function account(): User;
}
