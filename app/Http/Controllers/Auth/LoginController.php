<?php

namespace App\Http\Controllers\Auth;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use JWTAuth;

class LoginController extends Controller
{
    private $users, $provider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $users, UserProviderInterface $provider)
    {
        $this->users    = $users;
        $this->provider = $provider;
    }

    /**
     * Login a user
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = ['email' => $request->post('email'), 'password' => $request->post('password') ];

        if ( $token = JWTAuth::attempt( $credentials ) ) {
            $user  = JWTAuth::user();

            $user['providers'] = JWTAuth::user()->providers->where('provider', '=', 'internal');

            $user[ 'provider' ] = 'internal';

            return response()->json([
                'user'       => $user,
                'token'      => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
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
