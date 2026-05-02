<?php

namespace App\Services\Pdca;

use App\Models\Review;
use App\Models\Score;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;

class PdcaStateLoader
{
    /**
     * @return array{scores: Collection, reviews: Collection, tasks: Collection}
     */
    public function load(User $user, int $testId): array
    {
        $scope = fn ($query) => $query->where('test_id', $testId)->where('user_id', $user->id);

        return [
            'scores' => Score::with('subject')->tap($scope)->get(),
            'reviews' => Review::with('subject')->tap($scope)->get(),
            'tasks' => Task::with('subject')->tap($scope)->orderBy('id')->get(),
        ];
    }
}
