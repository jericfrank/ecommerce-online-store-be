<?php

namespace App\Http\Controllers\Auth;

use App\Services\Interfaces\UserInterface;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class LoginController extends Controller
{
    private $users;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Login a user
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if ($this->users->attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user = $this->users->user();

            $user['providers'] = $user->providers->where('provider', '=', 'internal');

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
