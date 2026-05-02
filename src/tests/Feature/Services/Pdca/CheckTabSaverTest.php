<?php

namespace Tests\Feature\Services\Pdca;

use App\Models\Score;
use App\Models\Task;
use App\Services\Pdca\CheckTabSaver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class CheckTabSaverTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_save_persists_checkboxes_and_actual_score(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();
        $score = Score::where('user_id', $this->user->id)->first();

        app(CheckTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            [
                'checkboxes' => [$task->id => true],
                'score' => [$score->id => 78],
            ],
        );

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => 1]);
        $this->assertDatabaseHas('scores', ['id' => $score->id, 'score' => 78]);
    }
}
