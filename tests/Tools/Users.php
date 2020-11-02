<?php

namespace Tests\Tools;

use App\Role;
use App\User;

trait Users
{
    public function getAdministrator()
    {
        return $this->generateUser('administrator');
    }

    public function getEmployee(): User
    {
        return $this->generateUser('employee');
    }

    public function getUser(): User
    {
        return $this->generateUser();
    }

    protected function generateUser(string $role = null): User
    {
        $user = factory(User::class)->create();

        if(Role::count() == 0)
            $this->populateRoles();

        if(! is_null($role) && in_array($role, Role::ROLES))
            $user->roles()->attach(Role::where(['name' => $role])->firstOrFail());

        return $user;
    }

    private function populateRoles(): bool
    {
        return Role::insert(array_map(function (string $role) {
            return ['name' => $role];
        }, Role::ROLES));
    }
}
