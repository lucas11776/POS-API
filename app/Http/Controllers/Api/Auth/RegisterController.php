<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Logic\Authentication;

class RegisterController extends Controller
{
    /**
     * @var Authentication
     */
    protected $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authentication->register($request->validated());

        return response()->json($this->authentication->respond_with_token($user));
    }
}
