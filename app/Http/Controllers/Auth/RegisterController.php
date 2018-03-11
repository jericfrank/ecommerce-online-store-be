<?php

namespace App\Http\Controllers\Auth;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Http\Controllers\Controller;

use JWTAuth;

class RegisterController extends Controller
{
    private $users, $providers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $users, UserProviderInterface $providers)
    {
        $this->users     = $users;
        $this->providers = $providers;
    }

    /**
     * Register a user
     *
     * @return Response
     */
    public function register(UserRequest $request)
    {
        $user     = $this->users->create($request->all());
        $provider = $this->providers->create([
            'avatar'      => $request->server()['HTTP_HOST'].'/img/default-avatar-250x250.png',
            'provider'    => 'internal',
            'user_id'     => $user->id
        ]);

        $user['providers'] = [ $provider ];

        $user->provider = 'internal';

        $token = JWTAuth::fromUser( $user );

        return [
            'user'  => $user,
            'token' => $token
        ];
    }
}
