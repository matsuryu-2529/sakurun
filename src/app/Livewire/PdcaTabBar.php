<?php

namespace App\Livewire;

use Livewire\Component;

class PdcaTabBar extends Component
{
    public $activeTab = 'plan';
    public $activeSubject = '数学1';

    protected $listeners = ['activeSubjectUpdated'];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function activeSubjectUpdated($subject)
    {
        $this->activeSubject = $subject;
    }

    public function render()
    {
        return view('livewire.pdca-tab-bar', [
            'activeSubject' => $this->activeSubject,
        ]);
    }
}
