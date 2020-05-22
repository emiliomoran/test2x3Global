<?php

use App\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Client::delete();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Client::create([
                'email' => $faker->unique()->email
            ]);
        };
    }
}
