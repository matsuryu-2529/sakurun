<?php

namespace Tests\Feature\Livewire\Students;

use App\Livewire\Students\Calendar;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_mount_initializes_to_current_month(): void
    {
        $this->createPdcaScenario();

        Livewire::actingAs($this->user)
            ->test(Calendar::class)
            ->assertSet('currentMonth', Carbon::now()->month)
            ->assertSet('currentYear', Carbon::now()->year);
    }

    public function test_load_tasks_returns_only_current_month_tasks(): void
    {
        $this->createPdcaScenario();
        Task::factory()->create([
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'subject_id' => $this->subject->id,
            'deadline' => Carbon::now()->subMonths(2)->format('Y-m-d'),
        ]);

        $component = Livewire::actingAs($this->user)->test(Calendar::class);

        $this->assertCount(1, $component->get('tasks'));
    }

    public function test_previous_month_navigates_back(): void
    {
        $this->createPdcaScenario();
        $expected = Carbon::now()->subMonth();

        Livewire::actingAs($this->user)
            ->test(Calendar::class)
            ->call('previousMonth')
            ->assertSet('currentMonth', $expected->month)
            ->assertSet('currentYear', $expected->year);
    }

    public function test_next_month_navigates_forward(): void
    {
        $this->createPdcaScenario();
        $expected = Carbon::now()->addMonth();

        Livewire::actingAs($this->user)
            ->test(Calendar::class)
            ->call('nextMonth')
            ->assertSet('currentMonth', $expected->month)
            ->assertSet('currentYear', $expected->year);
    }

    public function test_select_date_updates_selected_date(): void
    {
        $this->createPdcaScenario();

        Livewire::actingAs($this->user)
            ->test(Calendar::class)
            ->call('selectDate', '2026-12-25')
            ->assertSet('selectedDate', '2026-12-25');
    }
}
