<div>
    <h2 class="subtitle">松岡 龍之介さんのデータ</h2>
    <div class="content">
        <section class="study-summary">
            <div class="nav-item">学習時間</div>
            <div class="under-line"></div>
            <p class="total-time">
                <span class="span">合計</span>
                <span class="total-hours">50</span>
                <span class="span">h</span>
            </p>
            <div class="subject-summary">
                <div class="subject">
                    <div class="pie pie-total">
                        <div class="pie-text pie-math1-text">
                            <div class="subject-name">数学1</div>
                            <div class="subject-time">20h</div>
                        </div>
                        <div class="pie-text pie-mathB-text">
                            <div class="subject-name">数学B</div>
                            <div class="subject-time">10h</div>
                        </div>
                        <div class="pie-text pie-comm-text">
                            <div class="subject-name">コミュ英</div>
                            <div class="subject-time">20h</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="separate-line"></div>
        <section class="task-list">
            <div class="nav-item">計画（タスク）</div>
            <div class="under-line"></div>
            <div class="task-dropdown">
                <div class="plan-subject" wire:click="toggleSection('math1')">
                    数学1
                    <span class="arrow">{{ in_array('math1', $openSections) ? '▲' : '▼' }}</span>
                </div>
                @if (in_array('math1', $openSections))
                    <div class="tasks">
                        <div class="task">
                            <span class="task-status">○</span>
                            <span class="task-deadline">5/20 までに</span>
                            <span class="task-title">教科書 P.100～150</span>
                            <span class="task-progress">| 80%</span>
                        </div>
                        <div class="task">
                            <span class="task-status">○</span>
                            <span class="task-deadline">5/31 までに</span>
                            <span class="task-title">４STEP P.100～170</span>
                            <span class="task-progress">| 20%</span>
                        </div>
                    </div>
                @endif

                <div class="plan-subject" wire:click="toggleSection('mathB')">
                    数学B
                    <span class="arrow">{{ in_array('mathB', $openSections) ? '▲' : '▼' }}</span>
                </div>
                @if (in_array('mathB', $openSections))
                    <div class="tasks">
                        <!-- 数学Bのタスクをここに追加 -->
                    </div>
                @endif

                <div class="plan-subject" wire:click="toggleSection('comm')">
                    コミュ英
                    <span class="arrow">{{ in_array('comm', $openSections) ? '▲' : '▼' }}</span>
                </div>
                @if (in_array('comm', $openSections))
                    <div class="tasks">
                        <!-- コミュ英のタスクをここに追加 -->
                    </div>
                @endif
            </div>
        </section>
        <div class="separate-line"></div>
        <section class="results">
            <div class="nav-item">結果</div>
            <div class="under-line"></div>
            <div class="result">
                <span class="result-subject">数学1</span>
                <span class="result-score">75 点</span>
            </div>
            <div class="result">
                <span class="result-subject">数学B</span>
                <span class="result-score">70 点</span>
            </div>
            <div class="result">
                <span class="result-subject">コミュ英</span>
                <span class="result-score">90 点</span>
            </div>
            <div class="total-score">
                <span>合計</span>
                <span class="total-score-points">700 点</span>
            </div>
        </section>
        <div class="buttons">
            <a class="back-button" href="/teacher">戻る</a>
            <button class="pdf-button">PDF化</button>
        </div>
    </div>
</div>
