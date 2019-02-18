<?php

namespace App\Console\Commands;

use App\Admin;
use Illuminate\Console\Command;

class RemoveAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:del
                            {email : Email address }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove admin account.';

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
     * @throws \Exception
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $this->error("There is no email specified.");
            die(128);
        }

        $admin = Admin::where('email', $email);
        if (!$admin->exists()) {
            $this->error("The user with email $email is not an admin.");
            die(1);
        }
        $admin = $admin->first();
        $fname = $admin->fname;
        $lname = $admin->lname;

        try {
            $admin->delete();
        } catch (\Exception $exception) {
            $this->error("Unable to delete admin. " . $exception->getMessage());
            die(0);
        }

        $this->info("Successfully removed $fname $lname as an admin.");
    }
}
