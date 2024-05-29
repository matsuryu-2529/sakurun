<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Test;
use App\Models\Subject;
use App\Models\Score;
use App\Models\Task;
use App\Models\Review;

class PdcaTabBar extends Component
{
    public $user, $test, $subject, $scores, $tasks, $reviews;
    public $target_scores = [], $score = [], $formatted_deadline, $task_content, $study_time, $progress, $review_contents = [];
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

    /* private function resetInputFields()
    {
        $this->target_scores = [];
        $this->formatted_deadline = '';
        $this->task_content = '';
        $this->study_time = '';
        $this->score = [];
        $this->progress = '';
        $this->review_contents = [];
    } */

    public function store()
    {
        /* $this->validate([
            'formatted_deadline' => 'required',
            'task_content' => 'required',
        ]); */

        // 保存処理をここに追加
        foreach ($this->target_scores as $subjectId => $score) {
            Score::updateOrCreate(
                ['subject_id' => $subjectId, 'test_id' => $this->test->id, 'user_id' => $this->user->id],
                ['target_score' => $score]
            );
        }

        session()->flash('message', '保存しました。');

        $this->closeModal();
        // $this->resetInputFields();
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
        }
    }

    public function activeTabUpdated($tab)
    {
        if ($this->isOpen) {
            $this->loadScores();
            $this->loadReviews();
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
        } elseif ($this->activeTab === 'do') {

        } elseif ($this->activeTab === 'check') {
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

    public function mount()
    {
        $this->user = User::find(1);
        $this->test = Test::find($this->user->test_id);
        $this->subject = Subject::find($this->activeSubjectId);
        $this->loadScores();
        $this->loadReviews();
        $this->tasks = Task::where('test_id', $this->test->id)->where('user_id', $this->user->id)->get();
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
