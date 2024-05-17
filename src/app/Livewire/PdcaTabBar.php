<?php

namespace App\Livewire;

use Livewire\Component;

class PdcaTabBar extends Component
{
    public $activeTab = 'plan';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.pdca-tab-bar');
    }
}
