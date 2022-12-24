<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserAddress;
use Faker\Factory as Faker;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_BD');
        for ($i=0; $i < 10; $i++) { 
            $ua = new UserAddress;
            $ua->address = $faker->address;
            $ua->zipcode = (strlen($faker->postcode) > 5) ? substr($faker->postcode,0,5) : $faker->postcode; ;
            $ua->sub_district = $faker->city;
            $ua->district = $faker->streetName;
            $ua->city = $faker->state;
            $ua->contry = $faker->country;
            $ua->save();
        }
    }
}
