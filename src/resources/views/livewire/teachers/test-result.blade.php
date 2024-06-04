<div>
    <h2 class="subtitle">{{ $user->username }}さんのテスト結果</h2>
    <div class="content">
        <div class="summary">
            <div class="circle-summary">
                <div class="circle-title">直近のテスト</div>
                <div class="circle-subtitle">
                    <div>合計</div>
                    @php
                        $test = $tests->where('id', $user->test_id)->first();
                        $totalScore = $scores->where('test_id', $test->id)->sum('score');
                    @endphp
                    <div><span class="total-points">{{ $totalScore }}</span> 点</div>
                </div>
            </div>
            <div class="chart-summary">
                <nav class="chart-nav">
                    <div class="chart-nav__item {{ $activeSubject === '合計' ? 'chart-nav__item--active' : '' }}" wire:click="setActiveSubject('合計')">
                        <span class="subject-nav__label">合計</span>
                        @if ($activeSubject === '合計')
                            <div class="subject-nav__underline"></div>
                        @endif
                    </div>
                    <div class="subject-nav__separator"></div>
                    @foreach ($subjects as $subject)
                        <div class="chart-nav__item {{ $activeSubject === $subject->subject_name ? 'chart-nav__item--active' : '' }}" wire:click="setActiveSubject('{{ $subject->subject_name }}')">
                            <span class="subject-nav__label">{{ $subject->subject_name }}</span>
                            @if ($activeSubject === $subject->subject_name)
                                <div class="subject-nav__underline"></div>
                            @endif
                        </div>
                        <div class="subject-nav__separator"></div>
                    @endforeach
                </nav>
                @if ($activeSubject === '合計')
                    <div class="chart-body">
                        @foreach ($tests as $test)
                            @php
                                $totalScore = $scores->where('test_id', $test->id)->sum('score');
                                $subjectCount = $subjects->count();
                                $averageScore = $subjectCount > 0 ? $totalScore / $subjectCount : 0;
                            @endphp
                            <div class="bar" style="height: {{ $averageScore }}%;">{{ $totalScore }}</div>
                        @endforeach
                    </div>
                @else
                    @foreach ($subjects as $subject)
                        @if ($activeSubject === $subject->subject_name)
                        @php $subjectScores = $scores->where('subject_id', $subject->id); @endphp
                            <div class="chart-body">
                                @foreach ($tests as $test)
                                    @php $score = $subjectScores->where('test_id', $test->id)->first(); @endphp
                                    @if ($score)
                                        <div class="bar" style="height: {{ $score->score }}%;">{{ $score->score }}</div>
                                    @else
                                        <div class="bar" style="height: 0%;">0</div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
                <div class="test-titles">
                    @foreach ($tests as $test)
                        <div class="test">{{ $test->test_name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="buttons">
            <a class="back-button" href="/teacher">戻る</a>
        </div>
    </div>
</div>
