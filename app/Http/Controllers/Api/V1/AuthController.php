<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    //

    public function showLogin()
    {

        return "Login Page";
    }
    public function login(UserLoginRequest $request)
    {

        $validatedUser = $request->validated();

        $credentials = [

            'email' => $validatedUser['email'],
            'password' => $validatedUser['password']
        ];

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $data['id'] = $user->id;
            $data['name'] =  $user->name;
            $data['access_Token'] = $user->createToken('accessToken')->accessToken;

            return response()->json([
                'msg' => 'You have logged in ! Welcome',
                'data' =>  $data
            ]);
        } else {

            return response()->json([
                'msg' => 'Incorrect Email or Passowrd',
            ], 401);
        }
        return $credentials;
    }

    public function register(UserRegisterRequest $request)
    {

        $validatedUser = $request->validated();

        try {

            $user =  User::create([

                'name' => $validatedUser['name'],
                'email' =>  $validatedUser['email'],
                'password' =>  Hash::make($validatedUser['password']) //12341234
            ]);

            return response()->json([
                'msg' => 'User Created',
                'data' =>  $user
            ]);
        } catch (Exception $exp) {

            return response()->json([
                'msg' => $exp->getMessage()
            ], $exp->getCode());
        }
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'msg' => 'Success Logout!'
        ]);
    }

    public function show(User $user)
    {

        return "Hello";
    }
}
