<?php

namespace App\Http\Requests\Auth;

class TeacherLoginRequest extends LoginRequest
{
    public function guard(): string
    {
        return 'teacher';
    }
}
