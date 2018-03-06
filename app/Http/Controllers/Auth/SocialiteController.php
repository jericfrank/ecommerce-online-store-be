<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\SocialiteRequest;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;

use Socialite;
use JWTAuth;

class SocialiteController extends Controller
{
    private $users;

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
    public function redirectToProvider(SocialiteRequest $request)
    {
        $payload = $request->all();

        $state = [
            'referer' => $payload[ 'callback' ]
        ];

        return Socialite::driver($payload[ 'provider' ])->with([ 'state' => $state ])->stateless()->redirect()->getTargetUrl();
    }

    /**
     * Obtain the provider callback proxy to referer
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $state = $request->get('state');
        $code  = $request->get('code');

        $redirect = $state[ 'referer' ].'?code='.$code.'&provider='.$provider;

        return redirect()->away( $redirect );
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderAuth( $provider ) {
        $socialite = Socialite::driver($provider)->stateless()->user();

        $user = $this->findOrCreateUser($socialite, $provider);

        return $user;
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

            $user->provider = $userProvider;
            
            return [
                'user'       => $user,
                'token'      => JWTAuth::fromUser( $user ),
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
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
            'user'       => $userCreate->with('providers'),
            'token'      => JWTAuth::fromUser( $userCreate ),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
