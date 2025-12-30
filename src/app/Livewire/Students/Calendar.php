<?php

namespace App\Livewire\Students;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Task;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $selectedDate;
    public $tasks = [];
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Task::where('user_id', $this->user->id)
            ->whereMonth('deadline', $this->currentMonth)
            ->whereYear('deadline', $this->currentYear)
            ->get();
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadTasks();
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadTasks();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function getCalendarDays()
    {
        $firstDay = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $startCalendar = $firstDay->copy()->startOfWeek();
        $endCalendar = $lastDay->copy()->endOfWeek();

        $days = [];
        $current = $startCalendar->copy();

        while ($current->lte($endCalendar)) {
            $days[] = [
                'date' => $current->format('Y-m-d'),
                'day' => $current->day,
                'isCurrentMonth' => $current->month === $this->currentMonth,
                'isToday' => $current->isToday(),
                'isSelected' => $current->format('Y-m-d') === $this->selectedDate,
                'tasks' => $this->getTasksForDate($current->format('Y-m-d'))
            ];
            $current->addDay();
        }

        return collect($days)->chunk(7);
    }

    public function getTasksForDate($date)
    {
        return $this->tasks->filter(function ($task) use ($date) {
            return Carbon::parse($task->deadline)->format('Y-m-d') === $date;
        });
    }

    public function getSelectedDateTasks()
    {
        return $this->tasks->filter(function ($task) {
            return Carbon::parse($task->deadline)->format('Y-m-d') === $this->selectedDate;
        });
    }

    public function render()
    {
        return view('livewire.students.calendar', [
            'calendarWeeks' => $this->getCalendarDays(),
            'selectedDateTasks' => $this->getSelectedDateTasks(),
            'currentMonthName' => Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('Y年n月')
        ]);
    }
}
