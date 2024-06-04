<div>
    <div class="navbar">
        <div class="nav-item">
            <div class="plan-nav {{ $activeTab === 'plan' ? 'active' : '' }}" wire:click="setActiveTab('plan')">Plan</div>
        </div>
        <div class="separator"></div>
        <div class="nav-item">
            <div class="do-nav {{ $activeTab === 'do' ? 'active' : '' }}" wire:click="setActiveTab('do')">Do</div>
        </div>
        <div class="separator"></div>
        <div class="nav-item">
            <div class="check-nav {{ $activeTab === 'check' ? 'active' : '' }}" wire:click="setActiveTab('check')">Check</div>
        </div>
        <div class="separator"></div>
        <div class="nav-item">
            <div class="action-nav {{ $activeTab === 'action' ? 'active' : '' }}" wire:click="setActiveTab('action')">Action</div>
        </div>
    </div>
    <livewire:students.subject-tab-bar />
    @php
        $filteredTasks = $tasks->filter(function ($task) use ($subject) {
            return $task->subject_id == $subject->id;
        });

        $score = $scores->where('subject_id', $subject->id)->first();
    @endphp
    @if ($activeTab === 'plan')
    <div class="plan">
        <div class="plan__header">
            @if (!$isOpen)
            <h2 class="plan__title">{{ $test->test_name }}</h2>
            @endif
            <div class="plan__question">
                <p class="plan__question-text">{{ $subject->subject_name }}の目標点数は？</p>
                <div class="plan__question-answer">
                    @if ($isOpen)
                        <textarea wire:model="target_scores.{{ $score->id }}" class="plan__question-answer-score"></textarea>
                    @else
                        <span class="plan__question-answer-score">{{ $score ? $score->target_score : 0 }}</span>
                    @endif
                    <span class="plan__question-answer-unit">点</span>
                </div>
            </div>
        </div>
        <div class="plan__tasks">
            <p class="plan__tasks-text">目標達成までにやるべきタスクは？</p>
            <ul class="plan__tasks-list">
                @foreach($filteredTasks as $task)
                    <li class="plan__task">
                        <div class="plan__task-row">
                            <div class="plan__task-checkbox">○</div>
                                <div class="plan__task-deadline">
                                @if ($isOpen)
                                    <input type="date" wire:model="deadlines.{{ $task->id }}" class="plan__task-deadline-date">
                                @else
                                    <span class="plan__task-deadline-date">{{ $task->formatted_deadline }}</span>
                                @endif
                                <span class="plan__task-deadline-label">までに</span>
                            </div>
                            @if ($isOpen)
                            <div class="delete-button-container">
                                <button type="button" class="plan__task-button delete" wire:click="deleteTask({{ $task->id }})" wire:confirm="本当にこのタスクを削除してもよろしいですか？">ー</button>
                            </div>
                            @endif
                        </div>
                        <div class="plan__task-content">
                            @if ($isOpen)
                                <textarea wire:model="task_contents.{{ $task->id }}" class="plan__task-text"></textarea>
                            @else
                                <p class="plan__task-text">{{ $task->task_content }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($isOpen)
            <div class="create-button-container">
                <button class="plan__task-button create" wire:click="addTask">＋</button>
            </div>
            @endif
        </div>
    </div>
    @elseif ($activeTab === 'do')
    <div class="do">
        <div class="do__header">
            <p class="do__title">今日はどのくらい勉強した？</p>
        </div>
        <div class="do__tasks">
            @foreach($filteredTasks as $task)
                <div class="do__task">
                    <div class="do__task-row">
                        <div class="do__task-checkbox">○</div>
                        <div class="do__task-content">
                        <p class="do__task-text">{{ $task->task_content }}</p>
                        </div>
                    </div>
                    <div class="do__task-progress">
                        <div class="do__task-progress-row">
                            <div class="do__task-time">
                                <div class="do__task-time-time">
                                    @if ($isOpen)
                                    <textarea wire:model.live="study_times.{{ $task->id }}" class="do__task-time-value"></textarea>
                                    @else
                                    <span class="do__task-time-value">{{ $task->study_time }}</span></span>
                                    @endif
                                    <span class="do__task-time-unit">h</span>
                                </div>
                                <span class="do__task-time-total"><span class="do__task-time-label">合計：</span>5<span class="do__task-time-unit">h</span></span>
                            </div>
                            <div class="do__task-progress-bar">
                                <div class="do__task-progress-value">
                                    @if ($isOpen)
                                        <textarea wire:model.live="progresses.{{ $task->id }}" class="do__task-progress-percentage"></textarea>
                                    @else
                                        <span class="do__task-progress-percentage">{{ $task->progress }}</span>
                                    @endif
                                    <span class="do__task-progress-unit">%</span>
                                </div>
                                <div class="do__progress-bar">
                                    <div class="do__progress-fill" style="width: {{ $task->progress }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @elseif ($activeTab === 'check')
    <div class="check">
        <div class="check__header">
            <div class="check__question">
            <p class="check__question-text">後期期末テストの点数は？</p>
            <div class="check__question-answer">
                @if ($isOpen)
                    <textarea wire:model="score.{{ $score->id }}" class="check__question-answer-score"></textarea>
                @else
                    <span class="check__question-answer-score">{{ $score ? $score->score : 0 }}</span>
                @endif
                <span class="check__question-answer-unit">点</span>
            </div>
            </div>
        </div>
        <div class="check__tasks">
            <p class="check__tasks-text">完了したタスクは？</p>
            <ul class="check__tasks-list">
                @foreach($filteredTasks as $task)
                    <li class="check__task">
                        <div class="check__task-row">
                        @if ($isOpen)
                        <input wire:model="checkboxes.{{ $task->id }}" type="checkbox" class="check__task-checkbox">
                        @else
                            @if ($task->completed)
                                <div class="check__task-checkbox">✔</div>
                            @else
                                <div class="check__task-checkbox">✖</div>
                            @endif
                        @endif
                        <div class="check__task-deadline">
                            <span class="check__task-deadline-date">{{ $task->formatted_deadline }}</span>
                            <span class="check__task-deadline-label">までに</span>
                        </div>
                        </div>
                        <div class="check__task-content">
                        <p class="check__task-text">{{ $task->task_content }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @elseif ($activeTab === 'action')
    <div class="action">
        <div class="action__header">
            <p class="action__title">タスクは計画通りに進んだ？</p>
        </div>
        <div class="action__content">
            <div class="action__reflection">
                @if ($isOpen)
                    <textarea wire:model="review_contents.{{ $review->id }}" class="action__reflection-text"></textarea>
                @else
                    <p class="action__reflection-text">{{ $reviews->where('subject_id', $subject->id)->first()->content }}</p>
                @endif
            </div>
        </div>
        <div class="action__review">
            @if ($isOpen)
                <div class="review-button">
                    <div class="review-button__text" wire:click="aiReview()">AIにレビューしてもらう</div>
                </div>
                <p class="action__review-text">{{ $reviews->where('subject_id', $subject->id)->first()->ai_review }}</p>
            @else
                <p class="action__review-title">AIのレビュー</p>
                <p class="action__review-text">{{ $reviews->where('subject_id', $subject->id)->first()->ai_review }}</p>
            @endif
        </div>
    </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    @error('target_score') <span class="error">{{ $message }}</span> @enderror
    @if ($isOpen)
        <div class="edit-button">
            <bottom class="edit-button__text" wire:click="store()">保存</bottom>
        </div>
    @else
        <div class="edit-button">
            <bottom class="edit-button__text" wire:click="edit()">編集</bottom>
        </div>
    @endif
</div>
