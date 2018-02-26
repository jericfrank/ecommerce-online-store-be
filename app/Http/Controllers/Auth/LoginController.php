<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Login a user
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user = Auth::user();
            
            $user['providers'] = Auth::user()->providers->where('provider', '=', 'internal');

            $token = $user->createToken('web')->accessToken;
            
            $user[ 'provider' ] = 'internal';

            return [
                'user'  => $user,
                'token' => $token
            ];
        }

        return response()->json('Unauthorized', 401);
    }

    /**
     * Logout a user
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        
        return response()->json(null, 204);
    }
}
