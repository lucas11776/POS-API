<?php

namespace App\Logic\User;

use App\Logic\Users\Users;
use App\User as UserModel;
use App\Logic\Interfaces\UserInterface;
use Illuminate\Http\UploadedFile;
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

    public function updatePersonalDetails(array $personalDetails): UserModel
    {
        return $this->users->updateAccountDetails(Auth::user(), $personalDetails);
    }

    public function updateDescription(array $description): UserModel
    {
        return $this->users->updateAccountDescription(Auth::user(), $description);
    }

    public function updateAddress(array $address): UserModel
    {
        return $this->users->updateAccountAddress(Auth::user(), $address);
    }

    public function uploadProfilePicture(UploadedFile $image): UserModel
    {
        return $this->users->uploadAccountProfilePicture(Auth::user(), $image);
    }

    public function resetProfilePicture(): UserModel
    {
        return $this->users->resetAccountProfilePicture(Auth::user());
    }
}
