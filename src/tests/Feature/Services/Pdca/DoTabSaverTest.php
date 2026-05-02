<?php

namespace Tests\Feature\Services\Pdca;

use App\Models\Task;
use App\Services\Pdca\DoTabSaver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class DoTabSaverTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_save_accumulates_study_time(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();
        $task->update(['study_time' => 100]);

        app(DoTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            [
                'progresses' => [$task->id => 50],
                'daily_study_times' => [$task->id => 30],
                'initial_total_times' => [$task->id => 100],
            ],
        );

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'study_time' => 130]);
    }

    public function test_save_marks_completed_when_progress_hits_100(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();

        app(DoTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            [
                'progresses' => [$task->id => 100],
                'daily_study_times' => [$task->id => 0],
                'initial_total_times' => [$task->id => 0],
            ],
        );

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'progress' => 100, 'completed' => 1]);
    }

    public function test_save_unmarks_completed_when_progress_drops_below_100(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();
        $task->update(['progress' => 100, 'completed' => true]);

        app(DoTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            [
                'progresses' => [$task->id => 80],
                'daily_study_times' => [$task->id => 0],
                'initial_total_times' => [$task->id => 0],
            ],
        );

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'progress' => 80, 'completed' => 0]);
    }
}
