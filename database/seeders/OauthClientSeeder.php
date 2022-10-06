<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->truncate();
        $array = array(
            [
                'user_id' => null,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'DYy9sQvGTotkhIGfKdGkZ4EEWUXdoh2ls6iyLobx',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2021-02-05 13:45:34',
                'updated_at' => '2021-02-05 13:45:34',
            ],
            [
                'user_id' => null,
                'name' => 'Laravel Password Grant Client',
                'secret' => 'sbvWnKPdU2PWTXeJkLIwpjljUgCmAXacWroUqLE5',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2021-02-05 13:45:34',
                'updated_at' => '2021-02-05 13:45:34',
            ]

        );
        DB::table('oauth_clients')->insert($array);
    }
}
