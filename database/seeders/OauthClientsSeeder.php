<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->truncate();
        DB::table('oauth_clients')
            ->insert([
                [
                    'user_id' => null,
                    'name' => 'Laravel Personal Access Client',
                    'secret' => 'vpkAUJu44hlRw5zqxWImO3CxdULn1jrP2oOjMb4Z',
                    'provider' => '',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => '1',
                    'password_client' => '1',
                    'revoked' => '0',
                ],
                [
                    'user_id' => null,
                    'name' => 'Laravel Password Grant Client',
                    'secret' => '40jkA3qDoV32Pb8JwLrKu4XmEQui8libN4j31iyY',
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => '0',
                    'password_client' => '1',
                    'revoked' => '0',
                ],
            ]);
    }
}
