<div class="check">
    <div class="check__header">
        <div class="check__question">
        <p class="check__question-text">後期期末テストの点数は？</p>
        <div class="check__question-answer">
            @if ($isOpen)
                <select wire:model="score.{{ $score->id }}" class="check__question-answer-select">
                    @foreach($scoreOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            @else
                <span class="check__question-answer-score">{{ $score ? $score->score : 0 }}点</span>
            @endif
        </div>
        </div>
    </div>
    <div class="check__tasks">
        <p class="check__tasks-text">完了したタスクは？</p>
        <ul class="check__tasks-list {{ $isOpen ? 'editing-mode' : '' }}">
            @foreach($filteredTasks as $task)
                <li class="check__task {{ $task->completed ? 'completed' : '' }}">
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
