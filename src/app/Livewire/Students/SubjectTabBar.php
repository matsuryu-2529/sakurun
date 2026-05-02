<?php

namespace App\Livewire\Students;

use App\Models\Test;
use Livewire\Component;

class SubjectTabBar extends Component
{
    public $activeSubjectId = 1;

    public $subjects;

    public $user;

    public $test;

    public function mount()
    {
        $this->user = auth()->user();
        $this->test = Test::find($this->user->test_id);
        $this->activeSubjectId = $this->test->subjects()->first()->id;
        $this->subjects = $this->test->subjects()->get();
    }

    public function setActiveSubjectId($subjectId)
    {
        $this->activeSubjectId = (int) $subjectId;
        $this->dispatch('activeSubjectIdUpdated', $subjectId);
    }

    public function render()
    {
        return view('livewire.students.subject-tab-bar', [
            'subjects' => $this->subjects,
        ]);
    }
}
