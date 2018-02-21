<?php

namespace App\Http\Controllers\Auth;

use App\Services\Interfaces\UserProviderInterface;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class LoginController extends Controller
{
    private $providers;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserProviderInterface $providers)
    {
        $this->providers = $providers;
    }

    /**
     * Login a user
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user     = Auth::user();
            $provider = $this->providers->findOneBy([ 'user_id', '=', $user->id ], [ 'provider', '=', 'internal' ]);
            $token    = $user->createToken('web')->accessToken;
            
            return [
                'user'     => $user,
                'provider' => $provider,
                'token'    => $token
            ];
        }

        return response('Unauthorized.', 401);
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
