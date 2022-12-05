<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_has_rules')->delete();
        $dateTime = date('Y-m-d H:i:s');
        $array = [];
        for($i = 1; $i <= 9; $i++){
            $array[] = [
                'user_id' => 1,
                'rule_id' => $i,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ];
        }
        DB::table('user_has_rules')->insert($array);
    }
}
