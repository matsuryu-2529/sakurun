<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Test;
use App\Models\Subject;
use App\Models\Score;
use App\Models\Task;
use App\Models\Review;
use Carbon\Carbon;

class PdcaTabBar extends Component
{
    public $user, $test, $subject, $scores, $tasks, $reviews;
    public $target_scores = [], $score = [], $review_contents = [],$deadlines = [], $task_contents = [], $study_times = [], $progresses = [], $checkboxes = [];
    public $activeTab = 'plan';
    public $activeSubjectId = 1;
    public $isOpen = false;
    protected $listeners = ['activeSubjectIdUpdated', 'activeTabUpdated'];

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

    public function loadScores()
    {
        $this->scores = Score::where('test_id', $this->test->id)->where('user_id', $this->user->id)->get();
        foreach ($this->scores as $score) {
            $this->target_scores[$score->subject_id] = $score->target_score;
            $this->score[$score->subject_id] = $score->score;
        }
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('test_id', $this->test->id)->where('user_id', $this->user->id)->get();
        foreach ($this->reviews as $review) {
            $this->review_contents[$review->subject_id] = $review->content;
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
        }
    }

    public function saveCurrentTabState()
    {
        if ($this->activeTab === 'plan') {
            $score = $this->scores
                ->where('subject_id', $this->activeSubjectId)
                ->first();
            if ($score) {
                $score->target_score = $this->target_scores[$this->activeSubjectId];
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
                    $task->study_time = $this->study_times[$task->id];
                    $task->progress = $this->progresses[$task->id];
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
                $score->score = $this->score[$this->activeSubjectId];
                $score->save();
            }
        } elseif ($this->activeTab === 'action') {
            $review = $this->reviews
                ->where('subject_id', $this->activeSubjectId)
                ->first();
            if ($review) {
                $review->content = $this->review_contents[$this->activeSubjectId];
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
    }

    public function mount()
    {
        $this->user = User::find(1);
        $this->test = Test::find($this->user->test_id);
        $this->activeSubjectId = $this->test->subjects()->first()->id;
        $this->subject = Subject::find($this->activeSubjectId);
        $this->loadScores();
        $this->loadReviews();
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.pdca-tab-bar', [
            'subject' => $this->subject,
            'user' => $this->user,
            'test' => $this->test,
            'scores' => $this->scores,
            'tasks' => $this->tasks,
            'reviews' => $this->reviews,
        ]);
    }
}
