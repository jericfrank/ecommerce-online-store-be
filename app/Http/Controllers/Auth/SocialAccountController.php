<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;

use Socialite;
use Auth;

class SocialAccountController extends Controller
{
    private $users;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'http://localhost:3000/contact';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $users, UserProviderInterface $provider)
    {
        $this->user     = $users;
        $this->provider = $provider;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $socialite = Socialite::driver($provider)->stateless()->user();
        
        $user = $this->findOrCreateUser($socialite, $provider);

        return $user;
        
        // return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($details, $userProvider)
    {
        $user = $this->user->findOneBy([ 'email', '=', $details->getEmail() ]);

        if ( $user )
        {
            $provider = $user->providers->where('provider_id', $details->getId());

            $attributes = [
                'avatar'      => $details->getAvatar(),
                'provider'    => $userProvider,
                'provider_id' => $details->getId(),
                'user_id'     => $user->id
            ];

            if ( $provider->isEmpty() ) 
            {
                $this->provider->create( $attributes );
            } else {
                $id = $provider->pluck('id')->first();

                $this->provider->update( $attributes, $id );
            }

            return [
                'user'  => $user,
                'token' => $user->createToken('web')->accessToken
            ];
        }

        $userCreate = $this->user->create([
            'name'     => $details->getName(),
            'email'    => $details->getEmail(),
            'password' => null
        ]);

        $this->provider->create([
            'avatar'      => $details->getAvatar(),
            'provider'    => $userProvider,
            'provider_id' => $details->getId(),
            'user_id'     => $userCreate->id
        ]);

        return [
            'user'  => $userCreate->with('providers'),
            'token' => $userCreate->createToken('web')->accessToken
        ];
    }
}
