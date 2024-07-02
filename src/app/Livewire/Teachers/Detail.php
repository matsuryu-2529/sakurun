<?php

namespace App\Livewire\Teachers;

use Livewire\Component;
use App\Models\Test;
use App\Models\Score;
use App\Models\User;
use App\Models\Task;

class Detail extends Component
{
    public $userId, $year, $user, $test, $scores, $subjects, $tasks;
    public $openSections = [];

    public function mount($userId, $year)
    {
        $this->userId = $userId;
        $this->year = $year;
        $this->user = User::findOrFail($this->userId);
        $this->test = Test::where('id', $this->user->test_id)->first();
        $this->scores = Score::where('user_id', $this->userId)->where('test_id', $this->test->id)->get();
        $this->subjects = $this->test->subjects()->get();
        $this->tasks = Task::where('user_id', $this->userId)->where('test_id', $this->test->id)->get();
    }

    public function toggleSection($section)
    {
        if (in_array($section, $this->openSections)) {
            $this->openSections = array_diff($this->openSections, [$section]);
        } else {
            $this->openSections[] = $section;
        }
    }

    public function render()
    {
        return view('livewire.teachers.detail');
    }
}
