<?php

namespace App\Livewire\Students;

use Livewire\Component;

class BottomTabBar extends Component
{
    public $activeTab = 'home';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->dispatch('updateTab', $tab);
    }

    public function render()
    {
        return view('livewire.students.bottom-tab-bar', ['activeTab' => $this->activeTab]);
    }
}
