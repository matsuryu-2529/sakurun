<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\User;
use App\Models\Test;
use App\Models\Score;
use App\Models\Review;

class Home extends Component
{
    public $user, $tests;
    public $selectedTestId;

    public function mount()
    {
        $this->user = User::find(1);
        $this->tests = Test::where('year', $this->user->year)->get();
    }

    public function render()
    {
        return view('livewire.students.home', [
            'user' => $this->user,
            'tests' => $this->tests,
        ]);
    }

    public function createNewPdca()
    {
        $this->user->test_id = $this->selectedTestId;
        $this->user->save();

        $subjects = Test::find($this->user->test_id)->subjects()->get();
        foreach ($subjects as $subject) {
            $score = new Score([
                'test_id' => $this->selectedTestId,
                'user_id' => $this->user->id,
                'subject_id' => $subject->id,
                'target_score' => 0,
                'score' => 0,
            ]);
            $score->save();
        }

        foreach ($subjects as $subject) {
            $review = new Review([
                'test_id' => $this->selectedTestId,
                'user_id' => $this->user->id,
                'subject_id' => $subject->id,
                'content' => '',
                'ai_review' => '',
            ]);
            $review->save();
        }

        $this->dispatch('setActiveTab', 'pdca');
        $this->dispatch('navigateToPdca', $this->selectedTestId);
    }
}
