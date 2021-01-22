<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->truncate();
        $faker = Faker::create('App\Article');
        for ($i=0; $i < 200; $i++){
            DB::table('students')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'middle_name' => $faker->lastName,
                'phone' => $faker->phoneNumber,
                'created_at' => Carbon::now(),
                'Updated_at' => Carbon::now(),
            ]);
        }
    }
}
