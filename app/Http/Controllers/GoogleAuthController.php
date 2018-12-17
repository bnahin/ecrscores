<?php

namespace App\Http\Controllers;

use App\Common\Bnahin\EcrchsServices,
    Laravel\Socialite\Facades\Socialite,
    Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\App;
use App\User;

class GoogleAuthController extends Controller
{
    protected $api;

    public function __construct(EcrchsServices $api)
    {
        $this->api = $api;
    }

    /**
     * Redirect to Google SSO.
     */
    public function redirect()
    {
        if (App::isLocal()) {
            return redirect()->route('oauth-callback');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google SSO Callback
     */
    public function handle()
    {
        $apiUser = $this->api->getUser();

        $user = User::where('email', $apiUser->email);
        if ($user->exists()) {
            //Exists!
            $user->update([
                'google_id'  => $apiUser->id,
                'email'      => $apiUser->email,
                'first_name' => $apiUser->given_name,
                'last_name'  => $apiUser->family_name
            ]);
            $user = $user->first();
        } else {
            //Create!
            $user = new User([
                'google_id'  => $apiUser->id,
                'email'      => $apiUser->email,
                'first_name' => $apiUser->given_name,
                'last_name'  => $apiUser->family_name
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('home');
    }
}
