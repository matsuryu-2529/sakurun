<?php

namespace App\Livewire\Teachers;

use Livewire\Component;
use App\Models\Test;
use App\Models\Score;
use App\Models\Subject;
use App\Models\User;

class TestResult extends Component
{
    public $userId, $year, $user, $tests, $scores, $subjects;
    public $activeSubject = '合計';

    public function mount($userId, $year)
    {
        $this->userId = $userId;
        $this->year = $year;
        $this->user = User::findOrFail($this->userId);
        $this->tests = Test::where('year', $this->year)->get();
        $this->scores = Score::where('user_id', $this->userId)->get();
        $this->subjects = Subject::all();
    }

    public function setActiveSubject($subject)
    {
        $this->activeSubject = $subject;
        $this->dispatch('activeSubjectUpdated', $this->activeSubject);
    }

    public function render()
    {
        return view('livewire.teachers.test-result');
    }
}
