<div>
    @if ($activeTab === 'home')
        <livewire:students.home />
    @elseif ($activeTab === 'calendar')
        <livewire:students.calendar />
    @elseif ($activeTab === 'pdca')
        <livewire:students.pdca />
    @elseif ($activeTab === 'account')
        <livewire:students.account />
    @endif
</div>
