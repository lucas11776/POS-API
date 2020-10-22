<?php


namespace App\Logic;


use App\Role;
use App\User as Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class User implements UserInterface
{
    public function addRole(Model $user, Role $role): void
    {
        $user->roles()->attach($role);
    }

    public function removeRole(Model $user, Role $role): void
    {
        $role = $user->roles()->find($role);

        $role->pivot->delete();
    }
}
