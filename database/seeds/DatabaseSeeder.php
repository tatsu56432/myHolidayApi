<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $holiday = new \App\Holiday();
//        $holiday->id = $faker->id;
        $holiday->name = $faker->name;
        $holiday->year = $faker->year;
        $holiday->month = $faker->month;
        $holiday->day = $faker->dayOfMonth;
        $holiday->save();

    }
}