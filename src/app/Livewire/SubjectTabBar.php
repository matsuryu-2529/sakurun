<?php

namespace App\Livewire;

use Livewire\Component;

class SubjectTabBar extends Component
{
    public $activeSubject = 'math1';

    public function setActiveSubject($subject)
    {
        $this->activeSubject = $subject;
    }

    public function render()
    {
        return view('livewire.subject-tab-bar');
    }
}
