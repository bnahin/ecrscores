<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //Loop through PSAT Data
        //Calculate percentiles w/ PSATHelper::calcTotalPercentile
    }
}
