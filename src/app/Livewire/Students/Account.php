<?php

namespace App\Livewire\Students;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Account extends Component
{
    public $user;
    public $username;
    public $year;
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // モーダル表示状態
    public $showNameModal = false;
    public $showYearModal = false;
    public $showPasswordModal = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->username = $this->user->username;
        $this->year = $this->user->year;
    }

    public function openNameModal()
    {
        $this->showNameModal = true;
        $this->username = $this->user->username;
    }

    public function closeNameModal()
    {
        $this->showNameModal = false;
        $this->username = $this->user->username;
    }

    public function updateName()
    {
        $this->validate([
            'username' => 'required|string|max:30',
        ]);

        $this->user->update(['username' => $this->username]);
        $this->closeNameModal();
        session()->flash('message', '名前を変更しました。');
    }

    public function openYearModal()
    {
        $this->showYearModal = true;
        $this->year = $this->user->year;
    }

    public function closeYearModal()
    {
        $this->showYearModal = false;
        $this->year = $this->user->year;
    }

    public function updateYear()
    {
        $this->validate([
            'year' => 'required|integer|min:1|max:3',
        ]);

        $this->user->update(['year' => $this->year]);
        $this->closeYearModal();
        session()->flash('message', '学年を変更しました。');
    }

    public function openPasswordModal()
    {
        $this->showPasswordModal = true;
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
    }

    public function closePasswordModal()
    {
        $this->showPasswordModal = false;
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->addError('current_password', '現在のパスワードが正しくありません。');
            return;
        }

        $this->user->update(['password' => Hash::make($this->new_password)]);
        $this->closePasswordModal();
        session()->flash('message', 'パスワードを変更しました。');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/student/login');
    }

    public function render()
    {
        return view('livewire.students.account');
    }
}
