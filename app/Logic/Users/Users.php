<?php


namespace App\Logic\Users;

use App\User as UserModel;
use App\Logic\Interfaces\UsersInterface;

class Users implements UsersInterface
{
    public function account(int $id): UserModel
    {
        return UserModel::with(['address', 'image', 'roles'])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function updateAccountDetails(UserModel $user, array $data): UserModel
    {
        foreach (['first_name', 'last_name', 'gender'] as $key)
            $user->{$key} = isset($data[$key]) ? $data[$key] : null;
        $user->save();
        return $user;
    }

    public function updateAccountDescription(UserModel $user, array $accountDescription): UserModel
    {
        $user->description = $accountDescription['description'];
        $user->save();
        return $user;
    }
}
