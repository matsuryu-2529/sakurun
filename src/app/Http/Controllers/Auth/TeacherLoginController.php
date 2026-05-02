<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\TeacherLoginRequest;
use Illuminate\Http\RedirectResponse;

class TeacherLoginController extends AbstractLoginController
{
    protected function guard(): string
    {
        return 'teacher';
    }

    protected function loginView(): string
    {
        return 'auth.teacher-login';
    }

    protected function loginUrl(): string
    {
        return '/teacher/login';
    }

    public function store(TeacherLoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended('/teacher');
    }
}
