<div class="calendar-container">
    <!-- カレンダーヘッダー -->
    <div class="calendar-header">
        <button wire:click="previousMonth" class="calendar-nav-button">‹</button>
        <h2 class="calendar-title">{{ $currentMonthName }}</h2>
        <button wire:click="nextMonth" class="calendar-nav-button">›</button>
    </div>

    <!-- 曜日ヘッダー -->
    <div class="calendar-weekdays">
        <div class="weekday">日</div>
        <div class="weekday">月</div>
        <div class="weekday">火</div>
        <div class="weekday">水</div>
        <div class="weekday">木</div>
        <div class="weekday">金</div>
        <div class="weekday">土</div>
    </div>

    <!-- カレンダーグリッド -->
    <div class="calendar-grid">
        @foreach($calendarWeeks as $week)
            <div class="calendar-week">
                @foreach($week as $day)
                    <div class="calendar-day {{ $day['isCurrentMonth'] ? 'current-month' : 'other-month' }} {{ $day['isToday'] ? 'today' : '' }} {{ $day['isSelected'] ? 'selected' : '' }}"
                         wire:click="selectDate('{{ $day['date'] }}')">
                        <div class="day-number">{{ $day['day'] }}</div>
                        @if($day['tasks']->count() > 0)
                            <div class="task-indicator">
                                <span class="task-count">{{ $day['tasks']->count() }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- 選択された日のタスク表示 -->
    @if($selectedDateTasks->count() > 0)
        <div class="selected-date-tasks">
            <h3 class="tasks-title">{{ \Carbon\Carbon::parse($selectedDate)->format('n月j日') }}のタスク</h3>
            <div class="tasks-list">
                @foreach($selectedDateTasks as $task)
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

    <style>
        .calendar-container {
            padding: 45px 20px 20px 20px;
            max-width: 400px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-nav-button {
            background-color: #ceafaf;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-nav-button:hover {
            background-color: #bf9e9e;
        }

        .calendar-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            margin-bottom: 10px;
        }

        .weekday {
            text-align: center;
            font-weight: bold;
            color: #666;
            padding: 10px 0;
            font-size: 14px;
        }

        .calendar-grid {
            display: grid;
            grid-template-rows: repeat(6, 1fr);
            gap: 1px;
            margin-bottom: 20px;
        }

        .calendar-week {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
        }

        .calendar-day {
            aspect-ratio: 1;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            cursor: pointer;
            position: relative;
            padding: 5px;
            background-color: #f9f9f9;
        }

        .calendar-day.current-month {
            background-color: white;
        }

        .calendar-day.other-month {
            color: #ccc;
            background-color: #f5f5f5;
        }

        .calendar-day.today {
            background-color: #e8f4f8;
            border-color: #ceafaf;
        }

        .calendar-day.selected {
            background-color: #ceafaf;
            color: white;
        }

        .calendar-day:hover {
            background-color: #f0f0f0;
        }

        .calendar-day.selected:hover {
            background-color: #bf9e9e;
        }

        .day-number {
            font-size: 14px;
            font-weight: bold;
        }

        .task-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .selected-date-tasks {
            margin-top: 20px;
        }

        .tasks-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .task-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: white;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .task-status {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }

        .task-status.completed {
            background-color: #4caf50;
            color: white;
        }

        .task-status.pending {
            background-color: #f0f0f0;
            color: #666;
        }

        .task-content {
            flex: 1;
        }

        .task-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .task-progress {
            font-size: 14px;
            color: #666;
        }

        .no-tasks {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .no-tasks p {
            color: #666;
            margin: 0;
        }
    </style>
</div>
