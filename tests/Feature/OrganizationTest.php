<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    public function test_get_organizations()
    {
        $user = User::first();
        $response = $this->actingAs($user, 'api')
            ->get('api/organizations');
        $response->assertStatus(200);
    }

    public function test_create_organization()
    {
        $user = User::first();
        $response = $this->actingAs($user, 'api')
            ->json('POST', 'api/organizations', [
                'title' => Str::random(10)
            ]);
        $response->assertStatus(201);
    }

    public function test_update_organization()
    {
        $user = User::first();
        $org = Organization::first();
        $response = $this->actingAs($user, 'api')
            ->json('PUT', "api/organizations/{$org->id}", [
                'title' => "Updated " . Str::random(10)
            ]);
        $response->assertStatus(200);
    }

    public function test_change_organization_status()
    {
        $user = User::first();
        $org = Organization::first();
        $response = $this->actingAs($user, 'api')
            ->json('PUT', "api/organization/change_active/{$org->id}", [
                'title' => "Updated " . Str::random(10)
            ]);
        $response->assertSee('data.active' == !Organization::find($org->id)->active)
            ->assertStatus(200);
    }
}
