<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function index(ForgotPasswordRequest $request)
    {
        Password::broker()->sendResetLink($request->validated());

        return response()
            ->json(['message' => 'Password reset link has been sent please check your email inbox']);
    }
}
