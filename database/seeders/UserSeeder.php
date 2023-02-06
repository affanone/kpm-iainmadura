<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new \App\Models\User();
        $u->email = "lp2m@ianmadura.ac.id";
        $u->username = "lp2m";
        $u->password = Hash::make("lp2m");
        $u->save();
    }
}
