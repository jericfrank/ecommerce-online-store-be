<?php

namespace App\Http\Controllers\Auth;

use App\UserProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class LoginController extends Controller
{
    /**
     * Login a user
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user     = Auth::user();
            $provider = UserProvider::where('user_id', '=', $user->id)->where('provider', '=', 'internal')->first();
            $token    = $user->createToken('web')->accessToken;
            
            return [
                'user'     => $user,
                'provider' => $provider,
                'token'    => $token
            ];
        }

        return abort(401, 'Login Error');
    }

    /**
     * Logout a user
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return [
            'success' => 1
        ];
    }
}
