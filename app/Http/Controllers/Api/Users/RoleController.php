<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Requests\User\RemoveRoleRequest;
use App\Role;
use App\User as Model;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddRoleRequest;
use App\Logic\User;

class RoleController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function add(Model $user, AddRoleRequest $request)
    {
        $role = Role::where($request->only(['name']))->firstOrFail();

        $this->user->addRole($user, $role);

        return response()->json($user->refresh());
    }

    public function remove(Model $user, RemoveRoleRequest $request)
    {
        $role = Role::where($request->only(['name']))->firstOrFail();

        $this->user->removeRole($user, $role);

        return response()->json($user->refresh());
    }
}
