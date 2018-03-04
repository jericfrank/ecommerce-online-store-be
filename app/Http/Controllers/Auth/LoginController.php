<?php

namespace App\Http\Controllers\Auth;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

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
        if ($this->users->attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user  = $this->users->user();
            $token = $this->users->token();
            
            $user['providers'] = $this->provider->findBy([ 'provider', '=', 'internal' ]);

            $user[ 'provider' ] = 'internal';

            return [
                'user'  => $user,
                'token' => $token->accessToken
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
