<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAccountDetailsRequest;
use App\Http\Requests\User\UpdateDescriptionRequest;
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
        return response($this->user->account());
    }

    public function update(UpdateAccountDetailsRequest $request)
    {
        return response($this->user->updatePersonalDetails($request->validated()));
    }

    public function updateDescription(UpdateDescriptionRequest $request)
    {
        return response($this->user->updateDescription($request->validated()));
    }
}
