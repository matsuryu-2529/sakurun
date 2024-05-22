<?php

use Illuminate\Support\Facades\Route;

Route::get('/student',  function () {
    return view('pdca');
});

Route::get('/teacher',  function () {
    return view('home');
});

Route::get('/test-result',  function () {
    return view('test-result');
});

Route::get('/detail',  function () {
    return view('detail');
});
