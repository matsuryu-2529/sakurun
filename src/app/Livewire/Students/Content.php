<?php

namespace App\Livewire\Students;

use Livewire\Component;

class Content extends Component
{
    public $activeTab = 'home';

    protected $listeners = ['updateTab', 'navigateToPdca'];

    public function updateTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function navigateToPdca($testId)
    {
        $this->activeTab = 'pdca';
        // $this->dispatch('navigateToPdca', $testId);
    }

    public function render()
    {
        return view('livewire.students.content', ['activeTab' => $this->activeTab]);
    }
}
