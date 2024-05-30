<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Test;
use App\Models\Subject;

class SubjectTabBar extends Component
{
    public $activeSubjectId = 1;
    public $subjects, $user, $test;

    public function mount()
    {
        $this->user = User::find(1);
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
        return view('livewire.subject-tab-bar', [
            'subjects' => $this->subjects,
        ]);
    }
}
