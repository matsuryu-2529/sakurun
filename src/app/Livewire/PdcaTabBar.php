<?php

namespace App\Livewire;

use Livewire\Component;

class PdcaTabBar extends Component
{
    public $activeTab = 'plan';
    public $activeSubject = '数学1';
    public $edit = false;

    protected $listeners = ['activeSubjectUpdated'];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function setEdit()
    {
        $this->edit = true;
    }

    public function
    resetEdit()
    {
        $this->edit = false;
    }

    public function activeSubjectUpdated($subject)
    {
        $this->activeSubject = $subject;
    }

    public function aiReview()
    {
        
    }

    public function render()
    {
        return view('livewire.pdca-tab-bar', [
            'activeSubject' => $this->activeSubject,
        ]);
    }
}
