<div>
    <aside class="search">
        <input type="text" placeholder="検索">
        <button>検索する</button>
    </aside>
    <main class="main-content">
        <section class="student-list">
            <div class="header-row">
                <span class="column">生徒名</span>
                <span class="column">学年</span>
                <span class="column">最終更新日</span>
                <span class="column">テストの結果</span>
                <span class="column">詳細</span>
            </div>
            <div class="student-row">
                <span class="student-name">松岡 龍之介</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-03</span>
                <a class="test-result" href="/test-result">確認する</a>
                <a class="details" href="/detail">詳細を見る</a>
            </div>
            <div class="student-row">
                <span class="student-name">東 祐介</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-01</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">浜田 隆二</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-04</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">山田 花子</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-02</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">中本 和葉</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-04-30</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">松浦 太郎</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-04</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">吉田 真奈</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-04</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">山内 真理子</span>
                <span class="grade">1</span>
                <span class="last-updated">2020-05-02</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">河本 優大</span>
                <span class="grade">2</span>
                <span class="last-updated">2020-05-03</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
            <div class="student-row">
                <span class="student-name">岸田 光葉</span>
                <span class="grade">2</span>
                <span class="last-updated">2020-05-04</span>
                <button class="test-result" wire:click="showTestResult()">確認する</button>
                <button class="details" wire:click="showDetail()">詳細を見る</button>
            </div>
        </section>
    </main>
    <div class="pagination">
        <button class="prev-page">&lt;</button>
        <button class="page active">1</button>
        <button class="page">2</button>
        <button class="page">3</button>
        <button class="page">4</button>
        <button class="next-page">&gt;</button>
    </div>
</div>
