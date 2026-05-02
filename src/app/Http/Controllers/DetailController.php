<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class DetailController extends Controller
{
    /**
     * ユーザーの詳細情報を表示
     *
     * @param  int  $user_id
     * @return view
     */
    public function showDetail($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('detail', ['userId' => $user_id, 'year' => $user->year]);
    }
}
