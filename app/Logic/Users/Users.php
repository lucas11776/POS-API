<?php


namespace App\Logic\Users;


use App\Logic\Interfaces\UsersInterface;
use App\User as UserModel;
use Illuminate\Support\Facades\Auth;

class Users implements UsersInterface
{
    public function account(int $id): UserModel
    {
        return UserModel::with(['address', 'image', 'roles'])
            ->where('id', $id)
            ->firstOrFail();
    }
}
