<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class QueueSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:queuesync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue all sync commands to be run in the background. 
    This should be run overnight.';

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
        Artisan::queue('scores:sync');
        $this->line('The synchronization process has been queued.');
    }
}
