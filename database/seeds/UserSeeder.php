<?php

use App\User;
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

        User::truncate();

        User::insert([
            "name" => "system admin",
            "email" => "admin@mail.com",
            "password" => bcrypt("123456"),
        ]);
    }
}
