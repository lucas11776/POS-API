<?php

namespace App\Http\Controllers\Api\Users;

use App\Logic\Users\Users;
use App\Role;
use App\User as Model;
use App\Logic\User\Role as RoleLogic;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RemoveRoleRequest;
use App\Http\Requests\User\AddRoleRequest;

class RoleController extends Controller
{
    /**
     * @var RoleLogic
     */
    protected $role;

    /**
     * @var Users
     */
    protected $users;

    public function __construct(RoleLogic $role, Users $users)
    {
        $this->role = $role;
        $this->users = $users;
    }

    public function add(Model $user, AddRoleRequest $request)
    {
        $role = $this->getRole($request->only(['name']));

        $this->role->add($user, $role);

        return response()->json($this->users->account($user->id));
    }

    public function remove(Model $user, RemoveRoleRequest $request)
    {
        $role = $this->getRole($request->only(['name']));

        $this->role->remove($user, $role);

        return response()->json($user->refresh());
    }

    protected function getRole(array $role): Role
    {
        return Role::query()->where($role)->firstOrFail();
    }
}
