<?php

use App\Actor;
use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Actor::truncate();
        for ($i = 0; $i < 10; $i++) {
            Actor::insert([
                "name" => "actor".$i,
            ]);
        }

    }
}
