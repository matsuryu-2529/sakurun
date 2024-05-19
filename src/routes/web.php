<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PDCATabBar;

Route::get('/student',  function () {
    return view('pdca');
});

Route::get('/teacher',  function () {
    return view('home');
});
