<?php

namespace App\Logic\Interfaces;

use App\Role;
use App\User;

interface RoleInterface
{
    /**
     * Add new user role.
     *
     * @param User $user
     * @param Role $role
     * @return void
     */
    public function add(User $user, Role $role): void;

    /**
     * Remove existing user role.
     *
     * @param User $user
     * @param Role $role
     */
    public function remove(User $user, Role $role): void;
}
