<div>
    <nav class="subject-nav">
        <div class="subject-nav__item {{ $activeSubject === 'math1' ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubject('math1')">
            <span class="subject-nav__label">数学1</span>
            @if ($activeSubject === 'math1')
                <div class="subject-nav__underline"></div>
            @endif
        </div>
        <div class="subject-nav__separator"></div>
        <div class="subject-nav__item {{ $activeSubject === 'english' ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubject('english')">
            <span class="subject-nav__label">コミュ英</span>
            @if ($activeSubject === 'english')
                <div class="subject-nav__underline"></div>
            @endif
        </div>
        <div class="subject-nav__separator"></div>
        <div class="subject-nav__item {{ $activeSubject === 'mathB' ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubject('mathB')">
            <span class="subject-nav__label">数学B</span>
            @if ($activeSubject === 'mathB')
                <div class="subject-nav__underline"></div>
            @endif
        </div>
    </nav>
</div>
