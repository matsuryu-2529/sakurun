<div>
    <nav class="subject-nav">
        <div class="subject-nav__item {{ $activeSubject === '数学1' ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubject('数学1')">
            <span class="subject-nav__label">数学1</span>
            @if ($activeSubject === '数学1')
                <div class="subject-nav__underline"></div>
            @endif
        </div>
        <div class="subject-nav__separator"></div>
        <div class="subject-nav__item {{ $activeSubject === 'コミュ英' ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubject('コミュ英')">
            <span class="subject-nav__label">コミュ英</span>
            @if ($activeSubject === 'コミュ英')
                <div class="subject-nav__underline"></div>
            @endif
        </div>
        <div class="subject-nav__separator"></div>
        <div class="subject-nav__item {{ $activeSubject === '数学B' ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubject('数学B')">
            <span class="subject-nav__label">数学B</span>
            @if ($activeSubject === '数学B')
                <div class="subject-nav__underline"></div>
            @endif
        </div>
    </nav>
</div>
