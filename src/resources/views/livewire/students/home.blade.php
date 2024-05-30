<div>
    <div class="history">
        <div class="history__header">
            <p class="history__title">過去のPDCAを振り返る</p>
            <div class="history__items">
                <div class="history__button">
                    <div class="history__button__text">1年生前期中間テスト</div>
                </div>
                <div class="history__button">
                    <div class="history__button__text">1年生後期中間テスト</div>
                </div>
                <div class="history__button">
                    <div class="history__button__text">1年生前期期末テスト</div>
                </div>
                <div class="history__button">
                    <div class="history__button__text">1年生後期期末テスト</div>
                </div>
            </div>
        </div>
        <div class="history__new">
            <p class="history__new-title">次のテストに向けて新しいPDCAを作成する</p>
            <div class="history__button">
                <div class="history__button__text">
                    新規PDCAを作成する
                </div>
            </div>
            <div class="history__new-item">
                <select class="history__new-test">
                    @foreach ($tests as $test)
                        <option>{{ $test->test_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

</div>
