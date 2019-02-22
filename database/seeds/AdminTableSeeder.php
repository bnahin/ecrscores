<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        $admins = [
            [
                'fname' => 'Blake',
                'lname' => 'Nahin',
                'email' => '115602@ecrchs.org'
            ],
            [
                'fname' => 'Fernando',
                'lname' => 'Delgado',
                'email' => 'f.delgado@ecrchs.net'
            ],
            [
                'fname' => 'David',
                'lname' => 'Hussey',
                'email' => 'd.hussey@ecrchs.net'
            ]
        ];

        foreach ($admins as $admin) {
            if (!Admin::where($admin)->exists()) {
                Admin::create($admin);
            }
        }

    }
}
