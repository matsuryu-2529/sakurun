<div class="calendar-grid">
    @foreach ($calendarWeeks as $week)
        <div class="calendar-week">
            @foreach ($week as $day)
                <div class="calendar-day {{ $day['isCurrentMonth'] ? 'current-month' : 'other-month' }} {{ $day['isToday'] ? 'today' : '' }} {{ $day['isSelected'] ? 'selected' : '' }}"
                     wire:click="selectDate('{{ $day['date'] }}')">
                    <div class="day-number">{{ $day['day'] }}</div>
                    @if ($day['tasks']->count() > 0)
                        <div class="task-indicator">
                            <span class="task-count">{{ $day['tasks']->count() }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
