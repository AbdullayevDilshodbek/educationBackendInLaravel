<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'Test User',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'organization_id' => Organization::get()->skip(0)->take(1)->last()->id,
            'position_id' => 1
        ]);
    }
}
