<?php

namespace App\Console\Commands;

use App\Helpers\PSATHelper;
use App\PSAT;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CalculatePercentiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:percentiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate score percentiles.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Calculating PSAT Percentiles...');
        //Loop through PSAT Data
        //Calculate percentiles w/ PSATHelper::calcTotalPercentile
        $scores = PSAT::whereNotNull('total')->get();
        foreach ($scores as $score) {
            $teacher = $score->teacher;
            $ssid = $score->ssid;
            $course = $score->course;
            $year = $score->year;
            $total = $score->total;

            //Period
            $periodPerc = PSATHelper::calcTotalPercentile($ssid, $total, $year,
                'period', $teacher, $course);

            //Teacher
            $teacherPerc = PSATHelper::calcTotalPercentile($ssid, $total, $year,
                'teacher', $teacher);

            //School
            $schoolPerc = PSATHelper::calcTotalPercentile($ssid, $total, $year);

            //Save Association


        }
    }
}
