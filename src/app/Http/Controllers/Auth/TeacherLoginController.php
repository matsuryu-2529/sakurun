<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherLoginController extends Controller
{
    /**
     * ログインフォームを表示
     */
    public function create()
    {
        return view('auth.teacher-login');
    }

    /**
     * ログイン処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'ユーザー名は必須です。',
            'password.required' => 'パスワードは必須です。',
        ]);

        $teacher = Teacher::where('username', $request->username)->first();

        if ($teacher && Hash::check($request->password, $teacher->password)) {
            Auth::guard('teacher')->login($teacher);
            return redirect()->intended('/teacher');
        }

        return back()->withErrors([
            'username' => '認証に失敗しました。',
        ])->onlyInput('username');
    }

    /**
     * ログアウト処理
     */
    public function destroy(Request $request)
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/teacher/login');
    }
}
