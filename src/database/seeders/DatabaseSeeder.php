<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\Test;
use App\Models\Score;
use App\Models\Review;
use App\Models\Task;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 科目データの作成
        $subjects = [
            ['subject_name' => '国語'],
            ['subject_name' => '数学'],
            ['subject_name' => '英語'],
            ['subject_name' => '理科'],
            ['subject_name' => '社会'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // テストデータの作成
        $tests = [
            ['test_name' => '第1回定期テスト', 'year' => 1],
            ['test_name' => '第2回定期テスト', 'year' => 1],
            ['test_name' => '第3回定期テスト', 'year' => 1],
            ['test_name' => '第1回定期テスト', 'year' => 2],
            ['test_name' => '第2回定期テスト', 'year' => 2],
            ['test_name' => '第3回定期テスト', 'year' => 2],
            ['test_name' => '第1回定期テスト', 'year' => 3],
            ['test_name' => '第2回定期テスト', 'year' => 3],
            ['test_name' => '第3回定期テスト', 'year' => 3],
        ];

        foreach ($tests as $test) {
            Test::create($test);
        }

        // テストと科目の関連付け
        $allTests = Test::all();
        $allSubjects = Subject::all();

        foreach ($allTests as $test) {
            $test->subjects()->attach($allSubjects->pluck('id'));
        }

        // ユーザーデータの作成
        $users = [
            [
                'username' => '田中太郎',
                'year' => 1,
                'password' => bcrypt('password'),
                'test_id' => 1,
            ],
            [
                'username' => '佐藤花子',
                'year' => 1,
                'password' => bcrypt('password'),
                'test_id' => 1,
            ],
            [
                'username' => '山田次郎',
                'year' => 2,
                'password' => bcrypt('password'),
                'test_id' => 4,
            ],
            [
                'username' => '鈴木美咲',
                'year' => 2,
                'password' => bcrypt('password'),
                'test_id' => 4,
            ],
            [
                'username' => '高橋健太',
                'year' => 3,
                'password' => bcrypt('password'),
                'test_id' => 7,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // 各ユーザーの各科目にスコアを作成
            foreach ($allSubjects as $subject) {
                Score::create([
                    'test_id' => $user->test_id,
                    'user_id' => $user->id,
                    'subject_id' => $subject->id,
                    'target_score' => rand(70, 100),
                    'score' => rand(50, 95),
                ]);

                // レビューデータを作成
                Review::create([
                    'test_id' => $user->test_id,
                    'user_id' => $user->id,
                    'subject_id' => $subject->id,
                    'content' => $subject->subject_name . 'の復習が必要です。',
                    'ai_review' => 'AI による' . $subject->subject_name . 'の学習アドバイス',
                ]);

                // タスクデータを作成
                for ($i = 1; $i <= 2; $i++) {
                    Task::create([
                        'test_id' => $user->test_id,
                        'user_id' => $user->id,
                        'subject_id' => $subject->id,
                        'deadline' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                        'task_content' => $subject->subject_name . 'の課題' . $i,
                        'study_time' => rand(30, 120),
                        'progress' => rand(0, 100),
                        'completed' => rand(0, 1),
                    ]);
                }
            }
        }
    }
}
