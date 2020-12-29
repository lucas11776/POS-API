<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAccountDetailsRequest;
use App\Http\Requests\User\UpdateAddressRequest;
use App\Http\Requests\User\UpdateDescriptionRequest;
use App\Http\Requests\User\UploadProfilePictureRequest;
use App\Logic\User\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(User $user)
    {
        return response()->json($this->user->account());
    }

    public function update(UpdateAccountDetailsRequest $request)
    {
        return response()->json($this->user->updatePersonalDetails($request->validated()));
    }

    public function updateDescription(UpdateDescriptionRequest $request)
    {
        return response()->json($this->user->updateDescription($request->validated()));
    }

    public function updateAddress(UpdateAddressRequest $request)
    {
        return response()->json($this->user->updateAddress($request->validated()));
    }

    public function uploadProfilePicture(UploadProfilePictureRequest $request)
    {
        return response()->json($this->user->uploadProfilePicture($request->file('image')));
    }

    public function resetProfilePicture()
    {
        return response()->json($this->user->resetProfilePicture());
    }
}
