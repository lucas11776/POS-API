<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
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
}
