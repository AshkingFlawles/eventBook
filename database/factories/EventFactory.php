<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'venue_id' => \App\Models\Venue::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
            'is_ticketed' => $this->faker->boolean,
        ];
    }
}
