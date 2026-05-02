<div class="plan">
    <div class="plan__header">
        @if (!$isOpen)
        <h2 class="plan__title">{{ $test->test_name }}</h2>
        @endif
        <div class="plan__question">
            <p class="plan__question-text">{{ $subject->subject_name }}の目標点数は？</p>
            <div class="plan__question-answer">
                @if ($isOpen)
                    <select wire:model="target_scores.{{ $score->id }}" class="plan__question-answer-select">
                        @foreach($scoreOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                @else
                    <span class="plan__question-answer-score">{{ $score ? $score->target_score : 0 }}点</span>
                @endif
            </div>
        </div>
    </div>
    <div class="plan__tasks">
        <p class="plan__tasks-text">目標達成までにやるべきタスクは？</p>
        <ul class="plan__tasks-list {{ $isOpen ? 'editing-mode' : '' }}">
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
