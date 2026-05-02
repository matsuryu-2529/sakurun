<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_content' => fake()->realText(30),
            'deadline' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'study_time' => fake()->numberBetween(0, 300),
            'total_study_time' => 0,
            'progress' => fake()->numberBetween(0, 100),
            'completed' => false,
            'test_id' => Test::factory(),
            'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'completed' => true,
            'progress' => 100,
        ]);
    }
}
