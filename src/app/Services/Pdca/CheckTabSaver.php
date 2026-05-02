<?php

namespace App\Services\Pdca;

use App\Models\Score;
use App\Models\Task;
use App\Models\User;

class CheckTabSaver implements TabSaver
{
    /**
     * @param  array{
     *     checkboxes: array<int, bool>,
     *     score: array<int, int>,
     * } $payload
     */
    public function save(User $user, int $testId, int $subjectId, array $payload): void
    {
        $tasks = Task::where('test_id', $testId)
            ->where('user_id', $user->id)
            ->where('subject_id', $subjectId)
            ->get();

        foreach ($tasks as $task) {
            if (array_key_exists($task->id, $payload['checkboxes'] ?? [])) {
                $task->completed = (bool) $payload['checkboxes'][$task->id];
                $task->save();
            }
        }

        $score = Score::where('test_id', $testId)
            ->where('user_id', $user->id)
            ->where('subject_id', $subjectId)
            ->first();

        if ($score && isset($payload['score'][$score->id])) {
            $score->score = (int) $payload['score'][$score->id];
            $score->save();
        }
    }
}
