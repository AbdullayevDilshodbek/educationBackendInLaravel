<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rules')->delete();
        $dateTime = date('Y-m-d H:i:s');
        $array = array(
            [
                'title' => 'Tashkilotlarni yaratish',
                'key' => 'add_organizations',
                'rule_model_id' => 1,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => "Tashkilotlarni ko'rish",
                'key' => 'show_organizations',
                'rule_model_id' => 1,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => "Tashkilotlarni yangilash",
                'key' => 'update_organizations',
                'rule_model_id' => 1,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => 'Lavozimlarni yaratish',
                'key' => 'add_positions',
                'rule_model_id' => 2,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => "Lavozimlarni ko'rish",
                'key' => 'show_positions',
                'rule_model_id' => 2,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => "Lavozimlarni yangilash",
                'key' => 'update_positions',
                'rule_model_id' => 2,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => 'Foydalanuvchilar yaratish',
                'key' => 'add_users',
                'rule_model_id' => 3,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => "Foydalanuvchilar ko'rish",
                'key' => 'show_users',
                'rule_model_id' => 3,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'title' => "Foydalanuvchilar yangilash",
                'key' => 'update_users',
                'rule_model_id' => 3,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
        );
        DB::table('rules')->insert($array);
    }
}
