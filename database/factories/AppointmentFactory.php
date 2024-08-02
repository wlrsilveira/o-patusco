<?php

namespace Database\Factories;

use App\Models\AnimalType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AppointmentFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'animal_name' => fake()->name,
            'animal_age' => fake()->numberBetween(1, 20),
            'symptoms' => fake()->sentence,
            'date' => fake()->date,
            'period' => fake()->randomElement(['morning', 'afternoon']),
            'doctor_id' => User::factory()->create()->id,
            'animal_type_id' => AnimalType::factory()->create()->id,
        ];
    }
}
