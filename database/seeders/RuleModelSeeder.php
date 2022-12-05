<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rule_models')->truncate();
        $dateTime = date('Y-m-d H:i:s');
        $array = array(
            [
                'title' => 'Tashkilot',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => 'Lavozim',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => 'Foydalanuvchilar',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
        );
        DB::table('rule_models')->insert($array);
    }
}
