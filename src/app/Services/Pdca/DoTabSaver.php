<?php

namespace App\Services\Pdca;

use App\Models\Task;
use App\Models\User;

class DoTabSaver implements TabSaver
{
    private const PROGRESS_COMPLETE = 100;

    /**
     * @param  array{
     *     progresses: array<int, int>,
     *     daily_study_times: array<int, float|int|string>,
     *     initial_total_times: array<int, float|int|string>,
     * } $payload
     */
    public function save(User $user, int $testId, int $subjectId, array $payload): void
    {
        $tasks = Task::where('test_id', $testId)
            ->where('user_id', $user->id)
            ->where('subject_id', $subjectId)
            ->get();

        foreach ($tasks as $task) {
            $initial = (float) ($payload['initial_total_times'][$task->id] ?? $task->study_time);
            $daily = (float) ($payload['daily_study_times'][$task->id] ?? 0);
            $task->study_time = $initial + $daily;

            if (isset($payload['progresses'][$task->id])) {
                $progress = (int) $payload['progresses'][$task->id];
                $task->progress = $progress;
                $task->completed = $progress >= self::PROGRESS_COMPLETE;
            }

            $task->save();
        }
    }
}
