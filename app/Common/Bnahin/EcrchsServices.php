<?php
/**
 * ECRCHS Google SSO Wrapper & Services
 * @author Blake Nahin <bnahin@live.com>
 */

namespace App\Common\Bnahin;

use App\Imports\PSATImport;
use App\Imports\SBACImport;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Maatwebsite\Excel\Facades\Excel;
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
        User::truncate(); //Refreshing teacher database
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
     * @return array
     */
    public function parseResults(): array
    {
        $hitArray = array();

        $years = Storage::directories();
        if (!$years) {
            return $hitArray;
        }

        foreach ($years as $year) {
            //Level 1 - Years
            $teachers = Storage::directories($year);
            if (!$teachers || empty($teachers)) {
                continue;
            }

            $numTeachers = 0;
            $fileHits = array();
            foreach ($teachers as $teacher) {
                //Level 2 - Teachers
                $teacherEmail = explode('/', $teacher)[1] ?? null; //Remove leading directory (year)
                $files = Storage::files($teacher); //Includes leading directory
                if (!$teacherEmail || !$files || empty($files)) {
                    continue;
                }

                $numTeachers++;
                foreach ($files as $file) {
                    //Level 3 - Excel Files
                    $filename = explode('.', explode('/', $file)[2])[0];

                    //Get grade from filename
                    //Must be the first 1 or 2 charactersz
                    preg_match('/^\d{1,2}/', $filename, $matches);
                    if (empty($matches)) {
                        continue;
                    }
                    $grade = $matches[0];

                    if (str_contains($filename, 'PSAT')) {
                        //PSAT Data
                        Excel::import(new PSATImport($teacherEmail, $grade, $year), $file);
                    } elseif (str_contains($filename, 'SBAC')) {
                        //SBAC Data
                        Excel::import(new SBACImport($teacherEmail, $grade, $year), $file);
                    }

                    if (!isset($fileHits[$filename])) {
                        $fileHits[$filename] = 1;
                    } else {
                        $fileHits[$filename]++;
                    }
                }
            }

            $hitArray[$year]['teachers'] = $numTeachers;
            $hitArray[$year]['files'] = $fileHits;
        }

        return $hitArray;
    }
}
