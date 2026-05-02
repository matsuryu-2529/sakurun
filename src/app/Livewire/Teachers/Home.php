<?php

namespace App\Livewire\Teachers;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public $search = '';

    public $searchTerm = '';

    protected $queryString = ['searchTerm'];

    public function performSearch()
    {
        $this->searchTerm = $this->search;
        $this->resetPage();
    }

    public function render()
    {
        $users = User::where('username', 'like', '%' . $this->searchTerm . '%')->paginate(10);

        return view('livewire.teachers.home', ['users' => $users]);
    }
}
