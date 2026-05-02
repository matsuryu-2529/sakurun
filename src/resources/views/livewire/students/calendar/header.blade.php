<div class="calendar-header">
    <button wire:click="previousMonth" class="calendar-nav-button">‹</button>
    <h2 class="calendar-title">{{ $currentMonthName }}</h2>
    <button wire:click="nextMonth" class="calendar-nav-button">›</button>
</div>

<div class="calendar-weekdays">
    <div class="weekday">日</div>
    <div class="weekday">月</div>
    <div class="weekday">火</div>
    <div class="weekday">水</div>
    <div class="weekday">木</div>
    <div class="weekday">金</div>
    <div class="weekday">土</div>
</div>
