<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Logic\Authentication;
use Illuminate\Http\Response;

class AuthController extends Controller
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

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = $this->authentication->login($credentials);

        if(is_null($user)) {
            return response()
                ->json(['message' => 'The username or password is invalid.'], Response::HTTP_UNAUTHORIZED);
        }

        return response()
            ->json($this->authentication->respond_with_token($user, isset($credentials['stay_logged_in'])));
    }
}
