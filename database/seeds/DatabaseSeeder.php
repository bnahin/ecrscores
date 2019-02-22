<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Sync immediately
        //Artisan::call('scores:sync');
        //$this->call(AdminTableSeeder::class);
        $this->call(ScoreRangeSeeder::class);
    }
}
