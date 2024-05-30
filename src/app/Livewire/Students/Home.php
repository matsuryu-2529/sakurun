<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\User;
use App\Models\Test;

class Home extends Component
{
    public $user, $tests;

    public function mount()
    {
        $this->user = User::find(1);
        $this->tests = Test::where('year', $this->user->year)->get();
    }

    public function render()
    {
        return view('livewire.students.home', [
            'user' => $this->user,
            'tests' => $this->tests,
        ]);
    }
}
