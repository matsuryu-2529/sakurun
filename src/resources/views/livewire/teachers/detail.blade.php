<div>
    <h2 class="subtitle">{{ $user->username }}さんのデータ</h2>
    <div class="content">
        <section class="study-summary">
            @php
                $totalStudyTime = $tasks->sum('study_time');
                $subjectTimes = $subjects->mapWithKeys(function($subject) use ($tasks) {
                    return [$subject->subject_name => $tasks->where('subject_id', $subject->id)->sum('study_time')];
                });

                $subjectColors = [
                    '数学1' => '#afceb2',
                    '数学B' => '#ceafaf',
                    'コミュ英' => '#B0AFCE',
                    '英表' => '#ffffff'
                ];

                $startAngle = 0;
                $gradients = [];
                foreach ($subjectTimes as $subject => $time) {
                    $percentage = ($time / $totalStudyTime) * 100;
                    $endAngle = $startAngle + $percentage;
                    $color = $subjectColors[$subject] ?? '#000'; // デフォルト色を設定
                    $gradients[] = "$color $startAngle% $endAngle%";
                    $startAngle = $endAngle;
                }

                $gradientString = implode(', ', $gradients);
            @endphp
            <div class="nav-item">学習時間</div>
            <div class="under-line"></div>
            <p class="total-time">
                <span class="span">合計</span>
                <span class="total-hours">{{ $totalStudyTime }}</span>
                <span class="span">h</span>
            </p>
            <div class="subject-summary">
                <div class="subject">
                    <div class="pie pie-total" style="background: conic-gradient({{ $gradientString }});">
                        @foreach ($subjectTimes as $subject => $time)
                            <div class="pie-text pie-{{ strtolower(str_replace(' ', '-', $subject)) }}-text">
                                <div class="subject-name">{{ $subject }}</div>
                                <div class="subject-time">{{ $time }}h</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <div class="separate-line"></div>
        <section class="task-list">
            <div class="nav-item">計画（タスク）</div>
            <div class="under-line"></div>
            <div class="task-dropdown">
                @foreach ($subjects as $subject)
                    <div class="plan-subject" wire:click="toggleSection('{{ $subject->subject_name }}')">
                        {{ $subject->subject_name }}
                        <span class="arrow">{{ in_array($subject->subject_name, $openSections) ? '▲' : '▼' }}</span>
                    </div>
                    @if (in_array($subject->subject_name, $openSections))
                        <div class="tasks">
                            @foreach ($tasks->where('subject_id', $subject->id) as $task)
                                <div class="task">
                                    <span class="task-status">○</span>
                                    <span class="task-deadline">{{ $task->formatted_deadline }} までに</span>
                                    <span class="task-title">{{ $task->task_content }}</span>
                                    <span class="task-progress">| {{ $task->progress }}%</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
        <div class="separate-line"></div>
        <section class="results">
            <div class="nav-item">結果</div>
            <div class="under-line"></div>
            @foreach ($subjects as $subject)
                <div class="result">
                    <span class="result-subject">{{ $subject->subject_name }}</span>
                    <span class="result-score">{{ $scores->where('subject_id', $subject->id)->first()->score }}</span>
                </div>
            @endforeach
            @php
                $totalScore = $scores->sum('score');
            @endphp
            <div class="total-score">
                <span>合計</span>
                <span class="total-score-points">{{ $totalScore }} 点</span>
            </div>
        </section>
        <div class="buttons">
            <a class="back-button" href="/teacher">戻る</a>
            <button class="pdf-button">PDF化</button>
        </div>
    </div>
</div>
