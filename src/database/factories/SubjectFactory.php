<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject_name' => fake()->randomElement(['国語', '数学', '英語', '理科', '社会']),
        ];
    }
}
