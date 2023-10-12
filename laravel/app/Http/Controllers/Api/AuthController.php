<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequestRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{

    function register(UserRequestRegister $validatedData) {

        $user = User::create([
            'firstname' => $validatedData->get('firstname'),
            'lastname' => $validatedData->get('lastname'),
            'email' => $validatedData->get('email'),
            'password' => Hash::make($validatedData->get('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    function login(UserRequest $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'Logout successfully',
        ]);
    }
}
