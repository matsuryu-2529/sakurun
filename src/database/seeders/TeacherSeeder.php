<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'username' => 'teacher001',
            'name' => '田中先生',
            'email' => 'teacher001@sakurun.com',
            'password' => Hash::make('teacher123'),
        ]);

        Teacher::create([
            'username' => 'teacher002',
            'name' => '佐藤先生',
            'email' => 'teacher002@sakurun.com',
            'password' => Hash::make('teacher123'),
        ]);

        Teacher::create([
            'username' => 'admin',
            'name' => '管理者',
            'email' => 'admin@sakurun.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
