<?php

namespace App\Logic\User;

use App\User;
use App\Role as RoleModel;
use App\Logic\Interfaces\RoleInterface;

class Role implements RoleInterface
{
    public function add(User $user, RoleModel $role): void
    {
        $user->roles()->attach($role);
    }

    public function remove(User $user, RoleModel $role): void
    {
        $role = $user->roles()->find($role);

        $role->pivot->delete();
    }
}
