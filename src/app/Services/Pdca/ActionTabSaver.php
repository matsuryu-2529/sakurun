<?php

namespace App\Services\Pdca;

use App\Models\Review;
use App\Models\User;

class ActionTabSaver implements TabSaver
{
    /**
     * @param  array{review_contents: array<int, string>}  $payload
     */
    public function save(User $user, int $testId, int $subjectId, array $payload): void
    {
        $review = Review::where('test_id', $testId)
            ->where('user_id', $user->id)
            ->where('subject_id', $subjectId)
            ->first();

        if ($review && isset($payload['review_contents'][$review->id])) {
            $review->content = $payload['review_contents'][$review->id];
            $review->save();
        }
    }
}
