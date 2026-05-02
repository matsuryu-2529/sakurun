<div class="do">
    <div class="do__header">
        <p class="do__title">今日はどのくらい勉強した？</p>
    </div>
    <div class="do__tasks {{ $isOpen ? 'editing-mode' : '' }}">
        @foreach($filteredTasks as $task)
            <div class="do__task {{ $task->progress == 100 ? 'completed' : '' }}">
                <div class="do__task-row">
                    <div class="do__task-checkbox">○</div>
                    <div class="do__task-content">
                    <p class="do__task-text">{{ $task->task_content }}</p>
                    </div>
                </div>
                <div class="do__task-progress">
                    <div class="do__task-progress-row">
                        <div class="do__task-time">
                            <span class="do__task-time-total"><span class="do__task-time-label">合計：</span>{{ $this->getTotalStudyTimeForTask($task->id) }}<span class="do__task-time-unit">h</span></span>
                            <div class="do__task-time-time">
                                @if ($isOpen)
                                <div class="do__task-input-container">
                                    <label class="do__task-input-label">今日</label>
                                    <select wire:model.live="daily_study_times.{{ $task->id }}" class="do__task-time-select">
                                        @foreach($studyTimeOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="do__task-progress-bar">
                            <div class="do__task-progress-value">
                                @if ($isOpen)
                                    <select wire:model.live="progresses.{{ $task->id }}" class="do__task-progress-select">
                                        @foreach($progressOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="do__task-progress-percentage">{{ $task->progress }}%</span>
                                @endif
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
