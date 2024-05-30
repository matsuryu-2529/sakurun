<div>
    <h2 class="subtitle">松岡 龍之介さんのテスト結果</h2>
    <div class="content">
        <div class="summary">
            <div class="circle-summary">
                <div class="circle-title">直近のテスト</div>
                <div class="circle-subtitle">
                    <div>合計</div>
                    <div><span class="total-points">700</span> 点</div>
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
                    <div class="chart-nav__item {{ $activeSubject === '数学1' ? 'chart-nav__item--active' : '' }}" wire:click="setActiveSubject('数学1')">
                        <span class="subject-nav__label">数学1</span>
                        @if ($activeSubject === '数学1')
                            <div class="subject-nav__underline"></div>
                        @endif
                    </div>
                    <div class="subject-nav__separator"></div>
                    <div class="chart-nav__item {{ $activeSubject === 'コミュ英' ? 'chart-nav__item--active' : '' }}" wire:click="setActiveSubject('コミュ英')">
                        <span class="subject-nav__label">コミュ英</span>
                        @if ($activeSubject === 'コミュ英')
                            <div class="subject-nav__underline"></div>
                        @endif
                    </div>
                    <div class="subject-nav__separator"></div>
                    <div class="chart-nav__item {{ $activeSubject === '数学B' ? 'chart-nav__item--active' : '' }}" wire:click="setActiveSubject('数学B')">
                        <span class="subject-nav__label">数学B</span>
                        @if ($activeSubject === '数学B')
                            <div class="subject-nav__underline"></div>
                        @endif
                    </div>
                </nav>
                @if ($activeSubject === '合計')
                    <div class="chart-body">
                        <div class="bar" style="height: 75%;">75</div>
                        <div class="bar" style="height: 70%;">70</div>
                        <div class="bar" style="height: 90%;">90</div>
                        <div class="bar" style="height: 100%;">100</div>
                    </div>
                @endif
                @if ($activeSubject === '数学1')
                    <div class="chart-body">
                        <div class="bar" style="height: 75%;">75</div>
                        <div class="bar" style="height: 70%;">70</div>
                        <div class="bar" style="height: 90%;">90</div>
                        <div class="bar" style="height: 80%;">80</div>
                    </div>
                @endif
                @if ($activeSubject === 'コミュ英')
                    <div class="chart-body">
                        <div class="bar" style="height: 75%;">75</div>
                        <div class="bar" style="height: 70%;">70</div>
                        <div class="bar" style="height: 90%;">90</div>
                        <div class="bar" style="height: 60%;">60</div>
                    </div>
                @endif
                @if ($activeSubject === '数学B')
                    <div class="chart-body">
                        <div class="bar" style="height: 75%;">75</div>
                        <div class="bar" style="height: 70%;">70</div>
                        <div class="bar" style="height: 90%;">90</div>
                        <div class="bar" style="height: 40%;">40</div>
                    </div>
                @endif
                <div class="test-titles">
                    <div class="test">前期中間テスト</div>
                    <div class="test">前期期末テスト</div>
                    <div class="test">後期中間テスト</div>
                    <div class="test">前期期末テスト</div>
                </div>
            </div>
        </div>
        <div class="buttons">
            <a class="back-button" href="/teacher">戻る</a>
        </div>
    </div>
</div>
