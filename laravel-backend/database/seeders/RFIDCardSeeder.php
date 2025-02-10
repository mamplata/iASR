<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RFID_Card;
use Faker\Factory as Faker;

class RFIDCardSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $departments = ['Engineering', 'Business', 'IT', 'Arts', 'Education'];
        $programs = ['Computer Science', 'Mechanical Eng', 'Finance', 'Psychology', 'Physics'];
        $yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];

        for ($i = 1; $i <= 20; $i++) {
            RFID_Card::create([
                'uid' => $faker->unique()->randomNumber(5),
                'deviceId' => $faker->numberBetween(1000, 9999),
                'studName' => $faker->name,
                'department' => $faker->randomElement($departments),
                'program' => $faker->randomElement($programs),
                'yearLevel' => $faker->randomElement($yearLevels),
            ]);
        }
    }
}
