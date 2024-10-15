<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Venue;
use App\Models\User;

class VenueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_view_the_venues_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/venues');
        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_create_a_venue()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $venueData = [
            'name' => 'Test Venue',
            'description' => 'Test Description',
            'location' => 'Test Location',
        ];

        $response = $this->actingAs($admin)->post('/venues', $venueData);
        $response->assertRedirect('/venues');
        $this->assertDatabaseHas('venues', $venueData);
    }
}
