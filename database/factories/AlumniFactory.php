<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumni>
 */
class AlumniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
        'gender' => $gender,
        'ewu_id_no' => fake()->unique()->numerify('user-####'),
        'title' => fake()->title(),
        'first_name' => fake()->firstName($gender),
        'middle_name' => fake()->firstName($gender),
        'last_name' => fake()->lastName(),
        'contact_number' => fake()->phoneNumber(),
        'nid' => fake()->randomDigit(),
        'blood_group' => fake()->bloodGroup(),
        'department_id' => fake()->randomElement([1, 2]),
        'email' => fake()->email(),
        'username' => fake()->userName(),
        'password' => '$2y$10$rbxutFG2VJsXNCXOuk4Qt.JenCJl9MrWR1VelbRw2zBqddVIzfHsO',
        ];
    }
}
