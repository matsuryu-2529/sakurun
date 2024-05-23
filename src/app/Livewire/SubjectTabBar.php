<?php

namespace App\Livewire;

use Livewire\Component;

class SubjectTabBar extends Component
{
    public $activeSubject = '数学1';

    public function setActiveSubject($subject)
    {
        $this->activeSubject = $subject;
        $this->dispatch('activeSubjectUpdated', $this->activeSubject);
    }

    public function render()
    {
        return view('livewire.subject-tab-bar');
    }
}
