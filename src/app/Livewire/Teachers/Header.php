<?php

namespace App\Livewire\Teachers;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public function logout()
    {
        Auth::guard('teacher')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/teacher/login');
    }

    public function render()
    {
        return view('livewire.teachers.header');
    }
}
