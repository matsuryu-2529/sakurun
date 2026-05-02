@if ($selectedDateTasks->count() > 0)
    <div class="selected-date-tasks">
        <h3 class="tasks-title">{{ \Carbon\Carbon::parse($selectedDate)->format('n月j日') }}のタスク</h3>
        <div class="tasks-list">
            @foreach ($selectedDateTasks as $task)
                <div class="task-item">
                    <div class="task-status {{ $task->completed ? 'completed' : 'pending' }}">
                        {{ $task->completed ? '✓' : '○' }}
                    </div>
                    <div class="task-content">
                        <div class="task-title">{{ $task->task_content }}</div>
                        <div class="task-progress">進捗: {{ $task->progress }}%</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="no-tasks">
        <p>{{ \Carbon\Carbon::parse($selectedDate)->format('n月j日') }}にはタスクがありません</p>
    </div>
@endif
