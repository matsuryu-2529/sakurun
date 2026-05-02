<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->realText(50),
            'ai_review' => null,
            'test_id' => Test::factory(),
            'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
        ];
    }
}
