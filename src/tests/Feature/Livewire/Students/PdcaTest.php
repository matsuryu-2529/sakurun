<?php

namespace Tests\Feature\Livewire\Students;

use App\Livewire\Students\Pdca;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class PdcaTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_pdca_can_mount_for_authenticated_student(): void
    {
        $this->createPdcaScenario();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->assertSet('activeTab', 'plan')
            ->assertSet('activeSubjectId', $this->subject->id)
            ->assertSet('isOpen', false);
    }

    public function test_open_and_close_modal(): void
    {
        $this->createPdcaScenario();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('openModal')
            ->assertSet('isOpen', true)
            ->call('closeModal')
            ->assertSet('isOpen', false);
    }

    public function test_set_active_tab_changes_tab(): void
    {
        $this->createPdcaScenario();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('setActiveTab', 'do')
            ->assertSet('activeTab', 'do')
            ->call('setActiveTab', 'check')
            ->assertSet('activeTab', 'check');
    }

    public function test_add_task_creates_task_in_database(): void
    {
        $this->createPdcaScenario();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('addTask');

        $this->assertDatabaseCount('tasks', 2);
    }

    public function test_delete_task_removes_task(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('deleteTask', $task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_save_plan_tab_persists_target_score_and_task_fields(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();
        $score = $this->user->scores()->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('openModal')
            ->set('activeTab', 'plan')
            ->set("target_scores.{$score->id}", 95)
            ->set("task_contents.{$task->id}", '更新済みタスク')
            ->set("deadlines.{$task->id}", now()->addDays(3)->format('Y-m-d'))
            ->call('store');

        $this->assertDatabaseHas('scores', ['id' => $score->id, 'target_score' => 95]);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'task_content' => '更新済みタスク']);
    }

    public function test_save_do_tab_auto_completes_when_progress_reaches_100(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('edit')
            ->set('activeTab', 'do')
            ->set("progresses.{$task->id}", 100)
            ->set("daily_study_times.{$task->id}", 60)
            ->call('store');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'progress' => 100,
            'completed' => 1,
            'study_time' => 60,
        ]);
    }

    public function test_save_check_tab_persists_score(): void
    {
        $this->createPdcaScenario();
        $score = $this->user->scores()->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('openModal')
            ->set('activeTab', 'check')
            ->set("score.{$score->id}", 78)
            ->call('store');

        $this->assertDatabaseHas('scores', ['id' => $score->id, 'score' => 78]);
    }

    public function test_save_action_tab_persists_review_content(): void
    {
        $this->createPdcaScenario();
        $review = $this->user->reviews()->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('openModal')
            ->set('activeTab', 'action')
            ->set("review_contents.{$review->id}", '振り返り内容')
            ->call('store');

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'content' => '振り返り内容']);
    }

    public function test_ai_review_persists_generated_text(): void
    {
        $this->createPdcaScenario();
        $review = $this->user->reviews()->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('aiReview');

        $this->assertNotEmpty($review->fresh()->ai_review);
    }

    public function test_save_plan_tab_rejects_empty_task_content(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('openModal')
            ->set('activeTab', 'plan')
            ->set("task_contents.{$task->id}", '')
            ->set("deadlines.{$task->id}", now()->format('Y-m-d'))
            ->call('store')
            ->assertHasErrors(["task_contents.{$task->id}" => 'required']);
    }

    public function test_updated_progresses_to_100_marks_checkbox_completed(): void
    {
        $this->createPdcaScenario();
        $task = Task::where('user_id', $this->user->id)->first();

        Livewire::actingAs($this->user)
            ->test(Pdca::class)
            ->call('edit')
            ->set("progresses.{$task->id}", 100)
            ->assertSet("checkboxes.{$task->id}", true);
    }
}
