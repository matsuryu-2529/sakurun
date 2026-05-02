<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;

class StudentLoginController extends AbstractLoginController
{
    protected function guard(): string
    {
        return 'web';
    }

    protected function loginView(): string
    {
        return 'auth.student-login';
    }

    protected function loginUrl(): string
    {
        return '/student/login';
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended('/student');
    }
}
