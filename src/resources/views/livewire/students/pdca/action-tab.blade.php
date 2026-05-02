@php
    $review = $reviews->where('subject_id', $subject->id)->first();
@endphp
<div class="action">
    <div class="action__header">
        <p class="action__title">タスクは計画通りに進んだ？</p>
    </div>
    <div class="action__content">
        <div class="action__reflection">
            @if ($isOpen)
                <textarea wire:model="review_contents.{{ $review->id }}" class="action__reflection-text"></textarea>
            @else
                <p class="action__reflection-text">{{ $review?->content }}</p>
            @endif
        </div>
    </div>
    <div class="action__review">
        @if ($isOpen)
            <div class="review-button">
                <div class="review-button__text" wire:click="aiReview()">AIにレビューしてもらう</div>
            </div>
            <p class="action__review-text">{{ $review?->ai_review }}</p>
        @else
            <p class="action__review-title">AIのレビュー</p>
            <p class="action__review-text">{{ $review?->ai_review }}</p>
        @endif
    </div>
</div>
