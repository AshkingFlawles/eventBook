<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Booking;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create(['role' => 'superUser']);
        User::factory()->create(['role' => 'admin']);
        User::factory()->create(['role' => 'customer']);

        Venue::factory(10)->create();
        Event::factory(30)->create();
        Booking::factory(100)->create();
    }
}
