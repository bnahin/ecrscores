<?php

namespace App\Console\Commands;

use App\Admin;
use Illuminate\Console\Command;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add 
                            {email : Email address }
                            {fname : First name }
                            {lname : Last name }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin account.';

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
        $email = $this->argument('email');
        $fname = $this->argument('fname');
        $lname = $this->argument('lname');

        if (!$email) {
            $this->error("There is no email specified.");
            die(128);
        }

        if (!str_contains($email, ['ecrchs.net', 'ecrchs.org']) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email "' . $email . '"');
            die(128);
        }

        $admin = Admin::where('email', $email);
        if (!$admin->exists()) {
            //Create Admin model & attach
            Admin::create([
                'fname' => $fname,
                'lname'  => $lname,
                'email'      => $email
            ]);
        } else {
            $this->error('The admin already exists.');
            die(1);
        }

        $this->info("Successfully set $fname $lname as an admin.");
    }
}
