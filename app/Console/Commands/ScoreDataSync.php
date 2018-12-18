<?php

namespace App\Console\Commands;

use App\Common\Bnahin\EcrchsServices;
use Illuminate\Console\Command;

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
        //for ($i = self::START; $i < substr(intval(date('Y')), 2); $i++) {
          //  $this->line($this->ecrchs->firePython(self::START));
        //}
        $this->ecrchs->parseResults();
    }
}
