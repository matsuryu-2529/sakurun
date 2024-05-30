<?php

namespace App\Livewire\Students;

use Livewire\Component;

class Content extends Component
{
    public $activeTab = 'home';

    protected $listeners = ['tabChanged' => 'updateTab'];

    public function updateTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.students.content', ['activeTab' => $this->activeTab]);
    }
}
