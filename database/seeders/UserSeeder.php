<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i < 9; $i++) { 
            $user = new User;
            $user->name = $faker->name($gender = null);
            $user->user_addresses_id = $faker->numberBetween($min = 1, $max = 10);
            $user->email = $faker->email;
            $user->password = $faker->password;
            $user->save();
        }
        
    }
}
