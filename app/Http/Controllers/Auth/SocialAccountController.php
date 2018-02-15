<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\UserProvider;

use Socialite;
use Auth;

class SocialAccountController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'http://localhost:3000/contact';

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
        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        // Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($details, $provider)
    {
        $authUser = User::with([ 'providers' => function($q) use($details) {
            $q->where('provider_id', $details->getId());
        } ])
        ->where('email', $details->getEmail())
        ->first();
        
        if ($authUser) {
            $user            = $authUser;
            $user->name      = $details->getName();
            $user->api_token = $details->token;
            $user->save();

            if ( $authUser->providers->isEmpty() ) {
                $userProvider = new UserProvider;
            } else {
                $userProvider = UserProvider::where('provider_id', $details->getId())->first();
            }
            
            $userProvider->avatar      = $details->getAvatar();
            $userProvider->provider    = $provider;
            $userProvider->provider_id = $details->getId();
            $userProvider->user_id     = $user->id;
            $userProvider->save();

            return $user;
        }

        $user            = new User;
        $user->name      = $details->getName();
        $user->email     = $details->getEmail();
        $user->api_token = $details->token;
        $user->password  = null;
        $user->save();

        $userProvider              = new UserProvider;
        $userProvider->avatar      = $details->getAvatar();
        $userProvider->provider    = $provider;
        $userProvider->provider_id = $details->getId();
        $userProvider->user_id     = $user->id;
        $userProvider->save();

        return $user;
    }

    /**
     * Logout the user.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::user()->api_token = '';
        Auth::user()->save();

        return redirect($this->redirectTo);
    }
}