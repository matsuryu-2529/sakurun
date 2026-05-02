<?php

namespace App\Livewire\Students;

use App\Models\Subject;
use App\Models\Task;
use App\Models\Test;
use App\Services\AiReviewService;
use App\Services\Pdca\PdcaStateLoader;
use App\Services\Pdca\TabSaverFactory;
use Carbon\Carbon;
use Livewire\Component;

class Pdca extends Component
{
    public $user;

    public $test;

    public $subject;

    public $scores;

    public $tasks;

    public $reviews;

    public $target_scores = [];

    public $score = [];

    public $review_contents = [];

    public $deadlines = [];

    public $task_contents = [];

    public $study_times = [];

    public $progresses = [];

    public $checkboxes = [];

    public $daily_study_times = [];

    public $initial_total_times = [];

    public $activeTab = 'plan';

    public $activeSubjectId = 1;

    public $isOpen = false;

    public $studyTimeOptions = [];

    public $progressOptions = [];

    public $scoreOptions = [];

    protected $listeners = ['activeSubjectIdUpdated', 'activeTabUpdated', 'deleteTask'];

    public function mount()
    {
        $this->user = auth()->user();
        $this->test = Test::find($this->user->test_id);
        $this->activeSubjectId = $this->test->subjects()->first()->id;
        $this->subject = Subject::find($this->activeSubjectId);

        $this->initializeOptions();
        $this->reloadState();
    }

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
        if ($this->activeTab === 'plan') {
            $this->validate([
                'deadlines.*' => ['required', 'date'],
                'task_contents.*' => ['required', 'string', 'max:100'],
            ]);
        }

        $this->saveCurrentTabState();
        $this->reloadState();

        session()->flash('message', '保存しました。');
        $this->closeModal();
    }

    public function edit()
    {
        foreach ($this->tasks as $task) {
            $this->initial_total_times[$task->id] = (float) $task->study_time;
            $this->daily_study_times[$task->id] = 0;
        }
        $this->openModal();
    }

    public function activeSubjectIdUpdated($subjectId)
    {
        $this->setActiveSubjectId($subjectId);
        if ($this->isOpen) {
            $this->reloadState();
        }
    }

    public function activeTabUpdated($tab)
    {
        if ($this->isOpen) {
            $this->reloadState();
        }
    }

    public function saveCurrentTabState()
    {
        $payload = [
            'target_scores' => $this->target_scores,
            'task_contents' => $this->task_contents,
            'deadlines' => $this->deadlines,
            'progresses' => $this->progresses,
            'daily_study_times' => $this->daily_study_times,
            'initial_total_times' => $this->initial_total_times,
            'checkboxes' => $this->checkboxes,
            'score' => $this->score,
            'review_contents' => $this->review_contents,
        ];

        app(TabSaverFactory::class)
            ->make($this->activeTab)
            ->save($this->user, $this->test->id, $this->activeSubjectId, $payload);

        if ($this->activeTab === 'do') {
            $this->mirrorProgressIntoCheckboxes();
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
        $this->initial_total_times[$task->id] = (float) $task->study_time;
    }

    public function aiReview(): void
    {
        $review = $this->reviews->where('subject_id', $this->subject->id)->first();
        if (! $review) {
            return;
        }

        $tasks = $this->tasks->where('subject_id', $this->subject->id);
        $scores = $this->scores->where('subject_id', $this->subject->id);

        $review->ai_review = app(AiReviewService::class)
            ->generateReview($tasks, $scores, collect([$review]));
        $review->save();

        $this->reloadState();
        session()->flash('message', 'AIレビューを生成しました。');
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
            $this->reloadState();
            session()->flash('message', 'タスクを削除しました。');
        }
    }

    public function getTotalStudyTimeForTask($taskId)
    {
        if ($this->isOpen && isset($this->initial_total_times[$taskId], $this->daily_study_times[$taskId])) {
            return $this->initial_total_times[$taskId] + (float) $this->daily_study_times[$taskId];
        }

        $task = $this->tasks->where('id', $taskId)->first();

        return $task ? (float) $task->study_time : 0;
    }

    public function updatedProgresses($value, $taskId)
    {
        if ($value == 100) {
            $this->checkboxes[$taskId] = true;
            $task = $this->tasks->where('id', $taskId)->first();
            if ($task) {
                session()->flash('message', '「' . $task->task_content . '」が完了しました！Check画面で確認できます。');
            }
        } elseif ($value < 100) {
            $this->checkboxes[$taskId] = false;
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

    private function reloadState(): void
    {
        $state = app(PdcaStateLoader::class)->load($this->user, $this->test->id);
        $this->scores = $state['scores'];
        $this->reviews = $state['reviews'];
        $this->tasks = $state['tasks'];

        foreach ($this->scores as $score) {
            $this->target_scores[$score->id] = $score->target_score;
            $this->score[$score->id] = $score->score;
        }

        foreach ($this->reviews as $review) {
            $this->review_contents[$review->id] = $review->content;
        }

        foreach ($this->tasks as $task) {
            $this->deadlines[$task->id] = $task->formatted_deadline_for_input;
            $this->task_contents[$task->id] = $task->task_content;
            $this->study_times[$task->id] = $task->study_time;
            $this->progresses[$task->id] = $task->progress;
            $this->checkboxes[$task->id] = $task->completed;
            $this->daily_study_times[$task->id] = 0;
            $this->initial_total_times[$task->id] = (float) $task->study_time;
        }
    }

    private function mirrorProgressIntoCheckboxes(): void
    {
        foreach ($this->progresses as $taskId => $progress) {
            $this->checkboxes[$taskId] = (int) $progress >= 100;
        }
    }

    private function initializeOptions(): void
    {
        $this->studyTimeOptions = [];
        for ($i = 0; $i <= 20; $i++) {
            $value = $i * 0.5;
            $this->studyTimeOptions[$value] = $value . 'h';
        }

        $this->progressOptions = [];
        for ($i = 0; $i <= 10; $i++) {
            $value = $i * 10;
            $this->progressOptions[$value] = $value . '%';
        }

        $this->scoreOptions = [];
        for ($i = 0; $i <= 20; $i++) {
            $value = $i * 5;
            $this->scoreOptions[$value] = $value . '点';
        }
    }
}
