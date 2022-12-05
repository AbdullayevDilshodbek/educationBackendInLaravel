<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_organizations()
    {
        $user = User::first();
        if (!$user) {
            User::create([
                'full_name' => 'Test User',
                'username' => 'admin123',
                'password' => bcrypt('admin123'),
                'position_id' => 1
            ]);
        }
        $response = $this->actingAs($user, 'api')
            ->get('api/organizations');
        $response->assertStatus(200);
    }

    public function test_create_organization()
    {
        $user = User::first();
        if (!$user) {
            User::create([
                'full_name' => 'Test User',
                'username' => 'admin123',
                'password' => bcrypt('admin123'),
                'position_id' => 1
            ]);
        }
        $response = $this->actingAs($user, 'api')
            ->json('POST', 'api/organizations', [
                'title' => 'For Test'
            ]);
        $response->assertStatus(201);
    }
}
