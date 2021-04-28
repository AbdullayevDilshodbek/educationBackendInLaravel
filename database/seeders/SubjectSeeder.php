<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->truncate();
        DB::table('subjects')
            ->insert([[
                    'subject_name' => 'Matematika'
                ],
                [
                    'subject_name' => 'Fizika'
                ],
                [
                    'subject_name' => 'Ona tili'
                ],
                [
                    'subject_name' => 'IELTS'
                ],
                [
                    'subject_name' => 'Kimyo'
                ],
                [
                    'subject_name' => 'Bialogiya'
                ]
            ]);
    }
}
