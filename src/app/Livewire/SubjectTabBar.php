<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;

class SubjectTabBar extends Component
{
    public $activeSubjectId = 1;
    public $subjects;

    public function mount()
    {
        $this->subjects = Subject::all();
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
