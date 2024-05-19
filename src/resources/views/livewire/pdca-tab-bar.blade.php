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
    <livewire:subject-tab-bar />
    @if ($activeTab === 'plan')
    <div class="plan">
        <div class="plan__header">
            <h2 class="plan__title">1年生後期期末テスト</h2>
            <div class="plan__question">
                <p class="plan__question-text">{{ $activeSubject }}の目標点数は？</p>
                <div class="plan__question-answer">
                    @if ($edit)
                        <textarea class="plan__question-answer-score">70</textarea>
                    @else
                        <span class="plan__question-answer-score">70</span>
                    @endif
                    <span class="plan__question-answer-unit">点</span>
                </div>
            </div>
        </div>
        <div class="plan__tasks">
            <p class="plan__tasks-text">目標達成までにやるべきタスクは？</p>
            <ul class="plan__tasks-list">
                <li class="plan__task">
                    <div class="plan__task-row">
                        <div class="plan__task-checkbox">○</div>
                        <div class="plan__task-deadline">
                        @if ($edit)
                            <textarea class="plan__task-deadline-date">5/20</textarea>
                        @else
                            <span class="plan__task-deadline-date">5/20</span>
                        @endif
                        <span class="plan__task-deadline-label">までに</span>
                        </div>
                    </div>
                    <div class="plan__task-content">
                        @if ($edit)
                            <textarea class="plan__task-text">教科書 P.100～150</textarea>
                        @else
                            <p class="plan__task-text">教科書 P.100～150</p>
                        @endif
                    </div>
                </li>
                <li class="plan__task">
                    <div class="plan__task-row">
                        <div class="plan__task-checkbox">○</div>
                        <div class="plan__task-deadline">
                        <span class="plan__task-deadline-date">5/31</span>
                        <span class="plan__task-deadline-label">までに</span>
                        </div>
                    </div>
                    <div class="plan__task-content">
                        <p class="plan__task-text">４STEP P.100～170</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    @elseif ($activeTab === 'do')
    <div class="do">
        <div class="do__header">
            <p class="do__title">今日はどのくらい勉強した？</p>
        </div>
        <div class="do__tasks">
            <div class="do__task">
                <div class="do__task-row">
                    <div class="do__task-checkbox">○</div>
                    <div class="do__task-content">
                    <p class="do__task-text">教科書 P.100～150</p>
                    </div>
                </div>
                <div class="do__task-progress">
                    <div class="do__task-progress-row">
                        <div class="do__task-time">
                            @if ($edit)
                            <textarea class="do__task-time-value">1</textarea>
                            @else
                            <span class="do__task-time-value">1</span></span>
                            @endif
                            <span class="do__task-time-unit">h</span>
                            <span class="do__task-time-total"><span class="do__task-time-label">合計：</span>5<span class="do__task-time-unit">h</span></span>
                        </div>
                        <div class="do__task-progress-bar">
                            <div class="do__task-progress-value">
                                @if ($edit)
                                    <textarea class="do__task-progress-percentage">20</textarea>
                                @else
                                    <span class="do__task-progress-percentage">20</span>
                                @endif
                                <span class="do__task-progress-unit">%</span>
                            </div>
                            <div class="do__progress-bar">
                                <div class="do__progress-fill" style="width: 20%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="do__task">
                <div class="do__task-row">
                    <div class="do__task-checkbox">○</div>
                    <div class="do__task-content">
                    <p class="do__task-text">教科書 P.100～150</p>
                    </div>
                </div>
                <div class="do__task-progress">
                    <div class="do__task-progress-row">
                        <div class="do__task-time">
                            <span class="do__task-time-value">1<span class="do__task-time-unit">h</span></span>
                            <span class="do__task-time-total"><span class="do__task-time-label">合計：</span>5<span class="do__task-time-unit">h</span></span>
                        </div>
                        <div class="do__task-progress-bar">
                            <div class="do__task-progress-value">
                                <span class="do__task-progress-percentage">20<span class="do__task-progress-unit">%</span></span>
                            </div>
                            <div class="do__progress-bar">
                                <div class="do__progress-fill" style="width: 20%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif ($activeTab === 'check')
    <div class="check">
        <div class="check__header">
            <div class="check__question">
            <p class="check__question-text">後期期末テストの点数は？</p>
            <div class="check__question-answer">
                @if ($edit)
                    <textarea class="check__question-answer-score">75</textarea>
                @else
                    <span class="check__question-answer-score">75</span>
                @endif
                <span class="check__question-answer-unit">点</span>
            </div>
            </div>
        </div>
        <div class="check__tasks">
            <p class="check__tasks-text">完了したタスクは？</p>
            <ul class="check__tasks-list">
            <li class="check__task">
                <div class="check__task-row">
                @if ($edit)
                <input type="checkbox" class="check__task-checkbox">
                @else
                <div class="check__task-checkbox">✔</div>
                @endif
                <div class="check__task-deadline">
                    <span class="check__task-deadline-date">5/20</span>
                    <span class="check__task-deadline-label">までに</span>
                </div>
                </div>
                <div class="check__task-content">
                <p class="check__task-text">教科書 P.100～150</p>
                </div>
            </li>
            <li class="check__task">
                <div class="check__task-row">
                <div class="check__task-checkbox">○</div>
                <div class="check__task-deadline">
                    <span class="check__task-deadline-date">5/31</span>
                    <span class="check__task-deadline-label">までに</span>
                </div>
                </div>
                <div class="check__task-content">
                <p class="check__task-text">４STEP P.100～170</p>
                </div>
            </li>
            </ul>
        </div>
    </div>
    @elseif ($activeTab === 'action')
    <div class="action">
        <div class="action__header">
            <p class="action__title">タスクは計画通りに進んだ？</p>
        </div>
        <div class="action__content">
            <div class="action__reflection">
                @if ($edit)
                    <textarea class="action__reflection-text">4STEPが5/31までに終わらずなかったことで復習が十分にできなかったので、早めに4STEPを終わらせる！</textarea>
                @else
                    <p class="action__reflection-text">4STEPが5/31までに終わらずなかったことで復習が十分にできなかったので、早めに4STEPを終わらせる！</p>
                @endif
            </div>
        </div>
        <div class="action__review">
            @if ($edit)
                <div class="review-button">
                    <bottom class="review-button__text" wire:click="aiReview()">AIにレビューしてもらう</bottom>
                </div>
                <p class="action__review-text">よくできました！目標点を上回る結果を出せたのは素晴らしいです。でも、4STEPを早めに終わらせることで、復習の時間をしっかり確保し、さらなる高得点を目指しましょう。計画的に勉強を進めることが大切ですよ。</p>
            @else
                <p class="action__review-title">AIのレビュー</p>
                <p class="action__review-text">よくできました！目標点を上回る結果を出せたのは素晴らしいです。でも、4STEPを早めに終わらせることで、復習の時間をしっかり確保し、さらなる高得点を目指しましょう。計画的に勉強を進めることが大切ですよ。</p>
            @endif
        </div>
    </div>
    @endif
    @if ($edit)
        <div class="edit-button">
            <bottom class="edit-button__text" wire:click="resetEdit()">保存</bottom>
        </div>
    @else
        <div class="edit-button">
            <bottom class="edit-button__text" wire:click="setEdit()">編集</bottom>
        </div>
    @endif
</div>
