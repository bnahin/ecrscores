<?php

namespace App\Console\Commands;

use App\Common\Bnahin\EcrchsServices;
use App\Percentile;
use App\PSAT;
use App\SBAC;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
     * Reccommendation: run scores:queue to queue for sync.
     * This will take a long time!!
     *
     * @return mixed
     */
    public function handle()
    {
        Cache::put('datasync', true, 60);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PSAT::truncate();
        SBAC::truncate();
        Percentile::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //for ($i = self::START; $i < substr(intval(date('Y')), 2); $i++) {
        //  $this->line($this->ecrchs->firePython(self::START));
        //}
        $this->info('Importing score data. This will take some time...');
        $result = $this->ecrchs->parseResults(); //Score data
        $this->call('scores:percentiles'); //PSAT Percentiles
        dump($result);

        Cache::forget('datasync');
        $this->info('Done!');

        return true;
    }
}
