<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\User;
use App\Models\Test;
use App\Models\Subject;
use App\Models\Score;
use App\Models\Task;
use App\Models\Review;
use Carbon\Carbon;

class Pdca extends Component
{
    public $user, $test, $subject, $scores, $tasks, $reviews;
    public $target_scores = [], $score = [], $review_contents = [],$deadlines = [], $task_contents = [], $study_times = [], $progresses = [], $checkboxes = [];
    public $daily_study_times = []; // 今日の学習時間入力用
    public $initial_total_times = []; // 編集開始時の累積時間
    public $activeTab = 'plan';
    public $activeSubjectId = 1;
    public $isOpen = false;

    // 選択肢の配列
    public $studyTimeOptions = [];
    public $progressOptions = [];
    public $scoreOptions = [];
    protected $listeners = ['activeSubjectIdUpdated', 'activeTabUpdated', 'deleteTask', 'navigateToPdca'];

    public function setActiveTab($tab)
    {
        if ($this->isOpen) {
            $this->saveCurrentTabState();
        }
        $this->activeTab = $tab;
        $this->dispatch('activeTabUpdated', $tab);
    }

    public function setActiveSubjectId($subjectId)
    {
        if ($this->isOpen) {
            $this->saveCurrentTabState();
        }
        $this->activeSubjectId = $subjectId;
        $this->subject = Subject::find($subjectId);
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        /* $this->validate([
            'formatted_deadline' => 'required',
            'task_content' => 'required',
        ]); */

        $this->saveCurrentTabState();

        $this->loadScores();
        $this->loadReviews();
        $this->loadTasks();

        session()->flash('message', '保存しました。');

        $this->closeModal();
    }

    public function edit()
    {
        // 編集開始時に累積時間を保存
        foreach ($this->tasks as $task) {
            $this->initial_total_times[$task->id] = (float)$task->study_time;
            $this->daily_study_times[$task->id] = 0; // 今日の入力時間は0から開始
        }
        $this->openModal();
    }

    public function activeSubjectIdUpdated($subjectId)
    {
        $this->setActiveSubjectId($subjectId);
        if ($this->isOpen) {
            $this->loadScores();
            $this->loadReviews();
            $this->loadTasks();
        }
    }

    public function activeTabUpdated($tab)
    {
        if ($this->isOpen) {
            $this->loadScores();
            $this->loadReviews();
            $this->loadTasks();
        }
    }

    /* public function navigateToPdca($testId)
    {
        // dd($testId);
        $this->user = auth()->user();
        $this->user->test_id = $testId;

        $this->test = Test::find($this->user->test_id);
        $this->activeSubjectId = $this->test->subjects()->first()->id;
        $this->subject = Subject::find($this->activeSubjectId);

        // $this->addScores();
        // $this->addReviews();

        $this->loadScores();
        $this->loadReviews();

        // $this->openModal();
    } */

    public function loadScores()
    {
        $this->scores = Score::where('test_id', $this->test->id)->where('user_id', $this->user->id)->get();
        foreach ($this->scores as $score) {
            $this->target_scores[$score->id] = $score->target_score;
            $this->score[$score->id] = $score->score;
        }
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('test_id', $this->test->id)->where('user_id', $this->user->id)->get();
        foreach ($this->reviews as $review) {
            $this->review_contents[$review->id] = $review->content;
        }
    }

    public function loadTasks()
    {
        $this->tasks = Task::where('test_id', $this->test->id)->where('user_id', $this->user->id)->get();
        foreach ($this->tasks as $task) {
            $this->deadlines[$task->id] = $task->formatted_deadline_for_input;
            $this->task_contents[$task->id] = $task->task_content;
            $this->study_times[$task->id] = $task->study_time;
            $this->progresses[$task->id] = $task->progress;
            $this->checkboxes[$task->id] = $task->completed;
            $this->daily_study_times[$task->id] = 0; // 今日の入力時間を初期化
            $this->initial_total_times[$task->id] = (float)$task->study_time; // 累積時間を保存
        }
    }

    public function saveCurrentTabState()
    {
        if ($this->activeTab === 'plan') {
            $score = $this->scores
                ->where('subject_id', $this->activeSubjectId)
                ->first();
            if ($score) {
                $score->target_score = $this->target_scores[$score->id];
                $score->save();
            }
            $tasks = $this->tasks
                ->where('subject_id', $this->activeSubjectId);
            if ($tasks) {
                foreach ($tasks as $task) {
                    $task->deadline = $this->deadlines[$task->id];
                    $task->task_content = $this->task_contents[$task->id];
                    $task->save();
                }
            }
        } elseif ($this->activeTab === 'do') {
            $tasks = $this->tasks
                ->where('subject_id', $this->activeSubjectId);
            if ($tasks) {
                foreach ($tasks as $task) {
                    // 累積時間 = 編集開始時の時間 + 今日入力した時間
                    $newTotalTime = $this->initial_total_times[$task->id] + (float)$this->daily_study_times[$task->id];
                    $task->study_time = $newTotalTime;
                    $task->progress = $this->progresses[$task->id];

                    // 進捗率が100%の場合、自動的にチェック済みにする
                    // 進捗率が100%未満の場合、チェックを外す
                    if ($this->progresses[$task->id] == 100) {
                        $task->completed = true;
                        $this->checkboxes[$task->id] = true; // フロントエンドの状態も更新
                    } elseif ($this->progresses[$task->id] < 100) {
                        $task->completed = false;
                        $this->checkboxes[$task->id] = false; // フロントエンドの状態も更新
                    }

                    $task->save();
                }
            }
        } elseif ($this->activeTab === 'check') {
            $tasks = $this->tasks
                ->where('subject_id', $this->activeSubjectId);
            if ($tasks) {
                foreach ($tasks as $task) {
                    $task->completed = $this->checkboxes[$task->id];
                    $task->save();
                }
            }
            $score = $this->scores
                ->where('subject_id', $this->activeSubjectId)
                ->first();
            if ($score) {
                $score->score = $this->score[$score->id];
                $score->save();
            }
        } elseif ($this->activeTab === 'action') {
            $review = $this->reviews
                ->where('subject_id', $this->activeSubjectId)
                ->first();
            if ($review) {
                $review->content = $this->review_contents[$review->id];
                $review->save();
            }
        }
    }

    public function addTask()
    {
        $task = new Task([
            'test_id' => $this->test->id,
            'user_id' => $this->user->id,
            'subject_id' => $this->activeSubjectId,
            'deadline' => Carbon::now()->format('Y-m-d'),
            'task_content' => '',
        ]);
        $task->save();
        $this->tasks->push($task);

        $this->deadlines[$task->id] = $task->formatted_deadline_for_input;
        $this->task_contents[$task->id] = '';
        $this->study_times[$task->id] = $task->study_time;
        $this->progresses[$task->id] = $task->progress;
        $this->checkboxes[$task->id] = $task->completed;
        $this->daily_study_times[$task->id] = 0;
        $this->initial_total_times[$task->id] = (float)$task->study_time;
    }

    public function addScores()
    {
        $subjects = $this->test->subjects()->get();
        foreach ($subjects as $subject) {
            $score = new Score([
                'test_id' => $this->test->id,
                'user_id' => $this->user->id,
                'subject_id' => $subject->id,
                'target_score' => 0,
                'score' => 0,
            ]);
            $score->save();
            $this->scores->push($score);

            $this->target_scores[$subject->id] = 0;
            $this->score[$subject->id] = 0;
        }
    }

    public function addReviews()
    {
        $subjects = $this->test->subjects()->get();
        foreach ($subjects as $subject) {
            $review = new Review([
                'test_id' => $this->test->id,
                'user_id' => $this->user->id,
                'subject_id' => $subject->id,
                'content' => '',
                'ai_review' => '',
            ]);
            $review->save();
            $this->reviews->push($review);

            $this->review_contents[$subject->id] = '';
        }
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
            session()->flash('message', 'タスクを削除しました。');
        }
    }

        public function getTotalStudyTimeForTask($taskId)
    {
        // 編集中の場合は累積時間を計算、そうでなければデータベースの値を使用
        if ($this->isOpen && isset($this->initial_total_times[$taskId]) && isset($this->daily_study_times[$taskId])) {
            return $this->initial_total_times[$taskId] + (float)$this->daily_study_times[$taskId];
        } else {
            $task = $this->tasks->where('id', $taskId)->first();
            return $task ? (float)$task->study_time : 0;
        }
    }

    public function updatedProgresses($value, $taskId)
    {
        // 進捗率が変更されたときにリアルタイムでチェックボックスの状態を更新
        if ($value == 100) {
            $this->checkboxes[$taskId] = true;
            // タスク名を取得してメッセージを表示
            $task = $this->tasks->where('id', $taskId)->first();
            if ($task) {
                session()->flash('message', '「' . $task->task_content . '」が完了しました！Check画面で確認できます。');
            }
        } elseif ($value < 100) {
            $this->checkboxes[$taskId] = false;
        }
    }

    public function mount()
    {
        $this->user = auth()->user();
        $this->test = Test::find($this->user->test_id);
        $this->activeSubjectId = $this->test->subjects()->first()->id;
        $this->subject = Subject::find($this->activeSubjectId);

        // 選択肢を初期化
        $this->initializeOptions();

        $this->loadScores();
        $this->loadReviews();
        $this->loadTasks();
    }

    private function initializeOptions()
    {
        // 学習時間の選択肢（0から10時間まで0.5時間刻み）
        $this->studyTimeOptions = [];
        for ($i = 0; $i <= 20; $i++) {
            $value = $i * 0.5;
            $this->studyTimeOptions[$value] = $value . 'h';
        }

        // 進捗率の選択肢（0から100%まで10%刻み）
        $this->progressOptions = [];
        for ($i = 0; $i <= 10; $i++) {
            $value = $i * 10;
            $this->progressOptions[$value] = $value . '%';
        }

        // 点数の選択肢（0から100点まで5点刻み）
        $this->scoreOptions = [];
        for ($i = 0; $i <= 20; $i++) {
            $value = $i * 5;
            $this->scoreOptions[$value] = $value . '点';
        }
    }

    public function render()
    {
        return view('livewire.students.pdca', [
            'subject' => $this->subject,
            'user' => $this->user,
            'test' => $this->test,
            'scores' => $this->scores,
            'tasks' => $this->tasks,
            'reviews' => $this->reviews,
        ]);
    }
}
