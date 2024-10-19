<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends BaseController
{
    public function login(Request $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where('email', $email)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                return $this->sendError("The provided credentials are incorrect.");
            }

            $user->access_token = $user->createToken('access_token')->plainTextToken;

            return UserResource::make($user);
        }catch(\Exception $e) {
            Log::error("User Login: User with email {$request->input('email')} failed to login in, ".$e->getMessage());
            return $this->sendError(__("main.invalid_email_or_password"));
        }
    }
}
