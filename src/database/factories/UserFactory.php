<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->regexify('[a-z]{8}'),
            'year' => fake()->numberBetween(1, 3),
            'password' => static::$password ??= Hash::make('password'),
            'test_id' => Test::factory(),
            'remember_token' => fake()->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
