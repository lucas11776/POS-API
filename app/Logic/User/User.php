<?php

namespace App\Logic\User;

use App\Logic\Users\Users;
use App\User as UserModel;
use App\Logic\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;

class User implements UserInterface
{
    /**
     * @var Users
     */
    protected $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function account(): UserModel
    {
        return $this->users->account(Auth::id());
    }
}
