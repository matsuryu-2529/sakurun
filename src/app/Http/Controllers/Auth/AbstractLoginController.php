<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

abstract class AbstractLoginController extends Controller
{
    abstract protected function guard(): string;

    abstract protected function loginView(): string;

    abstract protected function loginUrl(): string;

    public function create(): View
    {
        return view($this->loginView());
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard($this->guard())->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($this->loginUrl());
    }
}
