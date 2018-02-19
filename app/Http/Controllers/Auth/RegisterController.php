<?php

namespace App\Http\Controllers\Auth;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Http\Controllers\Controller;

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
        $user = $this->users->create($request->all());

        $provider  = $this->providers->create([
            'avatar'      => '/default-avatar-250x250.png',
            'provider'    => 'internal',
            'user_id'     => $user->id
        ]);

        $token = $user->createToken('web')->accessToken;

        return [
            'user'     => $user,
            'provider' => $provider,
            'token'    => $token
        ];
    }
}
