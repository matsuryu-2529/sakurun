<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class StudentSignupController extends Controller
{
    /**
     * サインアップフォームを表示
     */
    public function create()
    {
        return view('auth.student-signup');
    }

    /**
     * 新しいユーザーを作成
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'year' => ['required', 'integer', 'min:1', 'max:3'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'username.required' => 'ユーザー名は必須です。',
            'username.unique' => 'このユーザー名は既に使用されています。',
            'year.required' => '学年は必須です。',
            'year.integer' => '学年は数値で入力してください。',
            'year.min' => '学年は1以上で入力してください。',
            'year.max' => '学年は3以下で入力してください。',
            'password.required' => 'パスワードは必須です。',
            'password.confirmed' => 'パスワードが一致しません。',
        ]);

        $user = User::create([
            'username' => $request->username,
            'year' => $request->year,
            'password' => Hash::make($request->password),
            'test_id' => 1, // デフォルト値
        ]);

        // ユーザーをログイン状態にする
        Auth::login($user);

        return redirect()->route('student.dashboard')->with('success', 'アカウントが正常に作成されました。');
    }
}
