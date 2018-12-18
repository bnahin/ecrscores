<?php
/**
 * ECRCHS Google SSO Wrapper & Services
 * @author Blake Nahin <bnahin@live.com>
 */

namespace App\Common\Bnahin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class EcrchsServices
{
    public $user;

    private $guzzle;
    private $PY_LOC;

    public function __construct()
    {
        $this->guzzle = new Client(['base_uri' => 'https://www.googleapis.com/oauth2/v2/']);
        $this->PY_LOC = Storage::path('data/Python/run_python.sh');
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

    /**
     * Fire Python synchronization script
     *
     * @param int $year
     *
     * @return string
     */
    public function firePython(int $year): string
    {
        $python = new Process(["sh {$this->PY_LOC}", $year]);
        try {
            $python->mustRun();
            $output = $python->getOutput();
        } catch (ProcessFailedException $exception) {
            $output = $exception->getMessage();
        }

        return $output;
    }

    /**
     * Parse CSV Results into JSON
     * @return bool
     */
    public function parseResults(): bool
    {
        $count = 0;

        $years = Storage::directories();
        if (!$years) {
            return false;
        }

        foreach ($years as $year) {
            //Level 1 - Years
            $teachers = Storage::directories($year);
            if (!$teachers || empty($teachers)) {
                continue;
            }

            foreach ($teachers as $teacher) {
                //Level 2 - Teachers
                $teacherEmail = explode('/', $teacher)[1] ?? null; //Remove leading directory (year)
                $files = Storage::files($teacher); //Includes leading directory
                if (!$teacherEmail || !$files || empty($files)) {
                    continue;
                }

                foreach ($files as $file) {
                    //Level 3 - Excel Files

                    //TODO: Maatwebsite Laravel Excel Import
                    //TODO: ^ Create import class, save to database or just collection??

                    $count++;
                }
            }
        }

        return $count > 0;
    }
}
