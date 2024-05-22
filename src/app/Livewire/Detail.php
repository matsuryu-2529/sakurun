<?php

namespace App\Livewire;

use Livewire\Component;

class Detail extends Component
{
    public $openSections = [];

    public function toggleSection($section)
    {
        if (in_array($section, $this->openSections)) {
            $this->openSections = array_diff($this->openSections, [$section]);
        } else {
            $this->openSections[] = $section;
        }
    }

    public function render()
    {
        return view('livewire.detail');
    }
}
