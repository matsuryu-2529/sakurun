<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\DetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/student/login', [App\Http\Controllers\Auth\StudentLoginController::class, 'create'])
    ->middleware('guest')
    ->name('student.login');

Route::post('/student/login', [App\Http\Controllers\Auth\StudentLoginController::class, 'store'])
    ->middleware('guest');

Route::get('/student/signup', [App\Http\Controllers\Auth\StudentSignupController::class, 'create'])
    ->middleware('guest')
    ->name('student.signup');

Route::post('/student/signup', [App\Http\Controllers\Auth\StudentSignupController::class, 'store'])
    ->middleware('guest');

Route::get('/teacher/login', [App\Http\Controllers\Auth\TeacherLoginController::class, 'create'])
    ->middleware('guest')
    ->name('teacher.login');

Route::post('/teacher/login', [App\Http\Controllers\Auth\TeacherLoginController::class, 'store'])
    ->middleware('guest');

Route::post('/teacher/logout', [App\Http\Controllers\Auth\TeacherLoginController::class, 'destroy'])
    ->middleware('auth:teacher')
    ->name('teacher.logout');

Route::get('/student',  function () {
    return view('students');
})->middleware('auth')->name('student.dashboard');

Route::get('/teacher',  function () {
    return view('home');
})->middleware('auth:teacher')->name('teacher.dashboard');

Route::get('/test-result/{id}', [TestResultController::class, 'showTestResult'])->name('test-result');

Route::get('/detail/{id}', [DetailController::class, 'showDetail'])->name('detail');

Route::get('/', function () {
    return redirect('/student/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
