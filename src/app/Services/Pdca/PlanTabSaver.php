<?php

namespace App\Services\Pdca;

use App\Models\Score;
use App\Models\Task;
use App\Models\User;

class PlanTabSaver implements TabSaver
{
    /**
     * @param  array{
     *     target_scores: array<int, int>,
     *     task_contents: array<int, string>,
     *     deadlines: array<int, string>,
     * } $payload
     */
    public function save(User $user, int $testId, int $subjectId, array $payload): void
    {
        $score = Score::where('test_id', $testId)
            ->where('user_id', $user->id)
            ->where('subject_id', $subjectId)
            ->first();

        if ($score && isset($payload['target_scores'][$score->id])) {
            $score->target_score = (int) $payload['target_scores'][$score->id];
            $score->save();
        }

        $tasks = Task::where('test_id', $testId)
            ->where('user_id', $user->id)
            ->where('subject_id', $subjectId)
            ->get();

        foreach ($tasks as $task) {
            if (isset($payload['deadlines'][$task->id])) {
                $task->deadline = $payload['deadlines'][$task->id];
            }
            if (isset($payload['task_contents'][$task->id])) {
                $task->task_content = $payload['task_contents'][$task->id];
            }
            $task->save();
        }
    }
}
