<?php

/**
 * Student Login Controller
 *
 * Handles student authentication requests
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Student Login Controller
 *
 * Handles student-specific authentication functionality
 */
class StudentLoginController extends Controller
{
    /**
     * Display the student login view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.student-login');
    }

    /**
     * Handle an incoming student authentication request.
     *
     * @param LoginRequest $request The login request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // ログイン成功後は学生ページへリダイレクト
        return redirect()->intended('/student');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request The request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/student/login');
    }
}
