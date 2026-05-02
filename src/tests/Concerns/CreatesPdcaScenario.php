<?php

namespace Tests\Concerns;

use App\Models\Review;
use App\Models\Score;
use App\Models\Subject;
use App\Models\Task;
use App\Models\Test;
use App\Models\User;

trait CreatesPdcaScenario
{
    protected User $user;

    protected Test $test;

    protected Subject $subject;

    /**
     * Build a complete PDCA scenario: a user assigned to a test that has one subject,
     * with score/review/task records ready to be edited.
     */
    protected function createPdcaScenario(int $year = 1): void
    {
        $this->test = Test::factory()->create(['year' => $year]);
        $this->subject = Subject::factory()->create();
        $this->test->subjects()->attach($this->subject->id);

        $this->user = User::factory()->create([
            'year' => $year,
            'test_id' => $this->test->id,
        ]);

        Score::factory()->create([
            'test_id' => $this->test->id,
            'subject_id' => $this->subject->id,
            'user_id' => $this->user->id,
            'target_score' => 80,
            'score' => 0,
        ]);

        Review::factory()->create([
            'test_id' => $this->test->id,
            'subject_id' => $this->subject->id,
            'user_id' => $this->user->id,
            'content' => '',
            'ai_review' => null,
        ]);

        Task::factory()->create([
            'test_id' => $this->test->id,
            'subject_id' => $this->subject->id,
            'user_id' => $this->user->id,
            'task_content' => '初期タスク',
            'deadline' => now()->format('Y-m-d'),
            'study_time' => 0,
            'progress' => 0,
            'completed' => false,
        ]);
    }
}
