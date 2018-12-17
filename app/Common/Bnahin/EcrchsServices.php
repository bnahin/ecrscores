<?php
/**
 * ECRCHS Google SSO Wrapper & Services
 * @author Blake Nahin <bnahin@live.com>
 */

namespace App\Common\Bnahin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class EcrchsServices
{
    private $guzzle;
    public $user;

    public function __construct()
    {
        $this->guzzle = new Client(['base_uri' => 'https://www.googleapis.com/oauth2/v2/']);
    }

    public function getUser()
    {
        if (App::isLocal()) {
            $headers = [
                'Authorization' => 'Bearer ' . config('services.google.client_secret')
            ];

            $response = $this->guzzle->get('userinfo', ['headers' => $headers])->getBody()
                ->getContents();

            $user = json_decode($response, true);
            $this->user = $user;
            $domain = $user['hd'];
        } else {
            $user = Socialite::driver('google')->user();
            $this->user = $user;
            $domain = explode("@", $user->email)[1];

            $this->user->hd = $domain;
            $name = explode(" ", $user->name);
            $this->user->given_name = $user['given_name'] ?? $name[0];
            $this->user->family_name = $user['family_name'] ?? explode(" ", $user->name)[count($name) - 1];
        }

        if (!in_array($domain, ["ecrchs.org"])) {
            return abort(403, "Not a member of the ECRCHS organization or forbidden from using the application");
        }

        return (object)$this->user;
    }
}
