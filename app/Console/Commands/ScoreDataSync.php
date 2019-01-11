<?php

namespace App\Console\Commands;

use App\Common\Bnahin\EcrchsServices;
use App\PSAT;
use App\SBAC;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ScoreDataSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve score data.';

    /**
     * The start year.
     */
    const START = 16;

    /**
     * ECRCHS Services Wrapper
     */
    private $ecrchs;

    /**
     * Create a new command instance.
     *
     * @param \App\Common\Bnahin\EcrchsServices $services
     */
    public function __construct(EcrchsServices $services)
    {
        parent::__construct();

        $this->ecrchs = $services;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Cache::put('datasync', true, 60);
        PSAT::truncate();
        SBAC::truncate();

        //for ($i = self::START; $i < substr(intval(date('Y')), 2); $i++) {
        //  $this->line($this->ecrchs->firePython(self::START));
        //}
        $this->info('Importing score data. This will take some time...');
        $result = $this->ecrchs->parseResults();

        dd($result);
        //TODO: make result symfony table

        Cache::forget('datasync');
        $this->info('Done!');

        return true;
    }
}
