<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\DetailController;


Route::get('/student',  function () {
    return view('students');
});

Route::get('/teacher',  function () {
    return view('home');
});

Route::get('/test-result/{id}', [TestResultController::class, 'showTestResult'])->name('test-result');

Route::get('/detail/{id}', [DetailController::class, 'showDetail'])->name('detail');
