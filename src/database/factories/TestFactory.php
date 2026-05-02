<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'test_name' => fake()->randomElement(['1学期中間テスト', '1学期期末テスト', '2学期中間テスト', '2学期期末テスト', '学年末テスト']),
            'year' => fake()->numberBetween(1, 3),
        ];
    }
}
