<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class TestResultController extends Controller
{
    /**
     * ユーザーのテスト結果を表示
     * @param int $user_id
     * @return view
     */
    public function showTestResult($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('test-result', ['userId' => $user_id, 'year' => $user->year]);
    }
}
