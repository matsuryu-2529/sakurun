<?php

namespace Tests\Feature\Services\Pdca;

use App\Models\Score;
use App\Models\Task;
use App\Services\Pdca\PlanTabSaver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class PlanTabSaverTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_save_persists_target_score_and_task_fields(): void
    {
        $this->createPdcaScenario();
        $score = Score::where('user_id', $this->user->id)->first();
        $task = Task::where('user_id', $this->user->id)->first();

        app(PlanTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            [
                'target_scores' => [$score->id => 95],
                'task_contents' => [$task->id => '更新済みタスク'],
                'deadlines' => [$task->id => '2026-12-31'],
            ],
        );

        $this->assertDatabaseHas('scores', ['id' => $score->id, 'target_score' => 95]);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'task_content' => '更新済みタスク']);
    }

    public function test_save_only_touches_active_subject(): void
    {
        $this->createPdcaScenario();
        $otherSubject = \App\Models\Subject::factory()->create();
        $this->test->subjects()->attach($otherSubject->id);

        $otherScore = Score::factory()->create([
            'test_id' => $this->test->id,
            'subject_id' => $otherSubject->id,
            'user_id' => $this->user->id,
            'target_score' => 50,
        ]);

        app(PlanTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            [
                'target_scores' => [$otherScore->id => 999],
                'task_contents' => [],
                'deadlines' => [],
            ],
        );

        $this->assertDatabaseHas('scores', ['id' => $otherScore->id, 'target_score' => 50]);
    }
}
