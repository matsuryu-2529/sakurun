<div>
    <nav class="bottom-tab-bar">
        <div class="bottom-tab-bar__item {{ $activeTab === 'home' ? 'bottom-tab-bar__item--active' : '' }}" data-icon="home" wire:click="setActiveTab('home')">
            <span class="bottom-tab-bar__label">Home</span>
        </div>
        <div class="bottom-tab-bar__item {{ $activeTab === 'calendar' ? 'bottom-tab-bar__item--active' : '' }}" data-icon="calendar" wire:click="setActiveTab('calendar')">
            <span class="bottom-tab-bar__label">Calendar</span>
        </div>
        <div class="bottom-tab-bar__item {{ $activeTab === 'pdca' ? 'bottom-tab-bar__item--active' : '' }}" data-icon="pdca" wire:click="setActiveTab('pdca')">
            <span class="bottom-tab-bar__label">PDCA</span>
        </div>
        <div class="bottom-tab-bar__item {{ $activeTab === 'account' ? 'bottom-tab-bar__item--active' : '' }}" data-icon="account" wire:click="setActiveTab('account')">
            <span class="bottom-tab-bar__label">Account</span>
        </div>
    </nav>
</div>
