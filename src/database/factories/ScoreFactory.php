<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'target_score' => fake()->numberBetween(60, 100),
            'score' => fake()->numberBetween(0, 100),
            'test_id' => Test::factory(),
            'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
        ];
    }
}
