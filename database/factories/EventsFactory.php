<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Events>
 */
class EventsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'organizer_id' => User::factory()->create(['role' => 'o'])->id, // Relacionamos un organizador
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => 1,
            'start_time' => now(),
            'end_time' => now()->addHours(2),
            'location' => $this->faker->city,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'max_attendees' => $this->faker->numberBetween(10, 200),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'image_url' => null,
            'deleted' => 0,
        ];
    }
}
