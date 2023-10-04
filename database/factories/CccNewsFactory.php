<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CccNews>
 */
class CccNewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'job_category_id' => 1,
            'title' => fake()->name(),
            'slug' => fake()->randomLetter(),
            'description' => fake()->text()
        ];
    }
}
