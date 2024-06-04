<div>
    <aside class="search">
        <input type="text" placeholder="検索" wire:model="search">
        <button wire:click="performSearch">検索する</button>
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
            @foreach ($users as $user)
                <div class="student-row">
                    <span class="student-name">{{ $user->username }}</span>
                    <span class="grade">{{ $user->year }}</span>
                    <span class="last-updated">{{ $user->updated_at }}</span>
                    <a class="test-result" href="/test-result/{{ $user->id }}">確認する</a>
                    <a class="details" href="/detail/{{ $user->id }}">詳細を見る</a>
                </div>
            @endforeach
        </section>
    </main>
    <div class="pagination">
        {{ $users->links('pagination') }}
    </div>
</div>
