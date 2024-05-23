<?php

namespace App\Livewire;

use Livewire\Component;

class TestResult extends Component
{
    public $activeSubject = '合計';

    public function setActiveSubject($subject)
    {
        $this->activeSubject = $subject;
        $this->dispatch('activeSubjectUpdated', $this->activeSubject);
    }

    public function render()
    {
        return view('livewire.test-result');
    }
}
