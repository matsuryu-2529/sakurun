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
        $filteredTasks = $tasks->filter(fn ($task) => $task->subject_id == $subject->id);
        $score = $scores->where('subject_id', $subject->id)->first();
    @endphp
    @switch($activeTab)
        @case('plan')
            @include('livewire.students.pdca.plan-tab')
            @break
        @case('do')
            @include('livewire.students.pdca.do-tab')
            @break
        @case('check')
            @include('livewire.students.pdca.check-tab')
            @break
        @case('action')
            @include('livewire.students.pdca.action-tab')
            @break
    @endswitch

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
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
