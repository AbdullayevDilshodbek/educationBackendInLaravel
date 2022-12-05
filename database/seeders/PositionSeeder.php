<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->delete();
        Position::create([
            'title' => 'admin',
            'organization_id' => Organization::first()->id,
            'active' => true
        ]);
    }
}
