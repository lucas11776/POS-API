<?php

namespace App\Logic;

use App\Role;
use App\User;

interface UserInterface
{
    /**
     * Add new user role.
     *
     * @param User $user
     * @param Role $role
     * @return Role
     */
    public function addRole(User $user, Role $role): void;

    /**
     * Remove existing user role.
     *
     * @param User $user
     * @param Role $role
     */
    public function removeRole(User $user, Role $role): void;
}
