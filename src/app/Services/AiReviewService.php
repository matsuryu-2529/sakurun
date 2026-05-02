<?php

namespace App\Services;

use Illuminate\Support\Collection;

class AiReviewService
{
    private const GOOD_PROGRESS_THRESHOLD = 70.0;

    private const POOR_PROGRESS_THRESHOLD = 50.0;

    private const SCORE_FAR_THRESHOLD_RATIO = 0.7;

    public function generateReview(Collection $tasks, Collection $scores, Collection $reviews): string
    {
        if ($tasks->isEmpty() && $scores->isEmpty() && $reviews->isEmpty()) {
            return '学習計画を立てて、まずは小さな一歩から取り組んでみましょう。';
        }

        $achievementRate = $this->calculateAchievementRate($tasks);
        $isScoreReached = $this->isScoreTargetReached($scores);
        $isScoreFar = $this->isScoreFarFromTarget($scores);

        if ($achievementRate >= self::GOOD_PROGRESS_THRESHOLD || $isScoreReached) {
            return '良いペースで進んでいます。この調子を継続していきましょう。';
        }

        if ($achievementRate < self::POOR_PROGRESS_THRESHOLD || $isScoreFar) {
            return '進捗に改善の余地があります。学習時間の確保や計画の見直しを検討してみましょう。';
        }

        return '計画通り順調に進んでいます。継続して取り組みましょう。';
    }

    public function calculateAchievementRate(Collection $tasks): float
    {
        if ($tasks->isEmpty()) {
            return 0.0;
        }

        return round($tasks->sum('progress') / $tasks->count(), 2);
    }

    public function calculateTotalStudyTime(Collection $tasks): int
    {
        return (int) $tasks->sum('study_time');
    }

    private function isScoreTargetReached(Collection $scores): bool
    {
        return $scores->isNotEmpty()
            && $scores->every(fn ($s) => $s->score >= $s->target_score);
    }

    private function isScoreFarFromTarget(Collection $scores): bool
    {
        return $scores->isNotEmpty()
            && $scores->contains(fn ($s) => $s->score < $s->target_score * self::SCORE_FAR_THRESHOLD_RATIO);
    }
}
