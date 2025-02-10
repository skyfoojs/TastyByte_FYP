<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'username' => fake()->userName(),
            'nickname' => fake()->word(),
            'role' => fake()->randomElement(['Admin', 'Cashier', 'Waiter', 'Kitchen']),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'dateOfBirth' => fake()->date(),
            'email' => fake()->unique()->safeEmail(),
            'phoneNo' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => fake()->randomElement(['Active', 'Inactive']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Define an Admin User state.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'username' => 'Admin',
            'nickname' => 'Admin',
            'role' => 'Admin',
            'gender' => 'Male',
            'dateOfBirth' => '1990-01-01',
            'email' => 'admin@example.com',
            'phoneNo' => '0123456789',
            'password' => Hash::make('admin'), // Secure password
            'status' => 'Active',
        ]);
    }
}
