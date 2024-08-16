<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * login
     */

    // public function login(LoginRequest $request)
    // {
    //     $token = auth()->attempt($request->validated());
    //     if ($token) {
    //         return $this->responseWithToken($token, auth()->user());
    //     } else {
    //         return response()->json(
    //             [
    //                 'status' => 'failed',
    //                 'message' => 'Login failed'
    //             ],
    //             401
    //         );
    //     }
    // }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unprocessable Entity'], 422);
        }
        return $this->createNewToken($token);
    }

    /**
     * register
     */

    public function register(RegistrationRequest $request)
    {
        $user = User::create($request->validated());
        if ($user) {
            $token = auth()->login($user);
            return $this->responseWithToken($token, $user);
        } else {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Registration failed'
                ],
                500
            );
        }
    }


    /**
     * Return JWT Token
     */

    public function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'type' => 'bearer',
        ]);
    }

    /**
     * user
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * google
     */
    public function redirectGoogle($provider)
    {
        // return 'wew ' . $provider;
        return Socialite::driver($provider)->redirect();
    }
    public function callbackGoogle($provider)
    {
        $socialite = Socialite::driver($provider)->user();

        $data = User::updateOrCreate([
            'provider_id' => $socialite->id,
            'provider' => $provider,
        ], [
            'name' => $socialite->name,
            'email' => $socialite->email,
            'provider_token' => $socialite->token,
        ]);
        // $toLogin
        if (!$token = auth()->attempt($data)) {
            return response()->json(['error' => 'Unprocessable Entity'], 422);
        }
        return $this->createNewToken($token);
        // return $user;
    }
    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }
}
