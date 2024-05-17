<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PDCATabBar;

Route::get('/',  function () {
    return view('pdca');
});
