<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Create a new user provider.
     *
     * @param  array  $data
     * @return \App\UserProvider
     */
    protected function provider(array $data)
    {
        return UserProvider::create([
            'avatar'      => $data['avatar'],
            'provider'    => $data['provider'],
            'provider_id' => null,
            'user_id'     => $data['user_id']
        ]);
    }

    /**
     * Register a user
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ( $validator->fails() ) {
            return response()->json([ 'errors' => $validator->errors() ], 400);
        }
        
        $user  = $this->create($request->all());
        
        $provider  = $this->provider([
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
