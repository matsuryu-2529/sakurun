<div>
    <nav class="subject-nav">
        @foreach($subjects as $subject)
            <div class="subject-nav__item {{ $activeSubjectId === $subject->id ? 'subject-nav__item--active' : '' }}" wire:click="setActiveSubjectId({{ $subject->id }})">
                <span class="subject-nav__label">{{ $subject->subject_name }}</span>
                @if ($activeSubjectId === $subject->id)
                    <div class="subject-nav__underline"></div>
                @endif
            </div>
            <div class="subject-nav__separator"></div>
        @endforeach
    </nav>
</div>
