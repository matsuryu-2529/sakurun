<div class="account-container">
    <!-- 成功メッセージ -->
    @if (session()->has('message'))
        <div class="success-message">
            {{ session('message') }}
        </div>
    @endif

    <!-- アカウント設定項目 -->
    <div class="account-items">
        <!-- 名前変更 -->
        <div class="account-item" wire:click="openNameModal">
            <div class="account-item-content">
                <div class="account-item-title">名前変更</div>
                <div class="account-item-icon">
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <path d="M25 5C19.5 5 15 9.5 15 15C15 20.5 19.5 25 25 25C30.5 25 35 20.5 35 15C35 9.5 30.5 5 25 5Z" fill="black"/>
                        <path d="M25 30C15 30 7 38 7 48H43C43 38 35 30 25 30Z" fill="black"/>
                        <text x="25" y="35" text-anchor="middle" fill="white" font-size="8" font-weight="bold">NAME</text>
                    </svg>
                </div>
            </div>
        </div>

        <!-- 学年変更 -->
        <div class="account-item" wire:click="openYearModal">
            <div class="account-item-content">
                <div class="account-item-title">学年変更</div>
                <div class="account-item-icon">
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <rect x="10" y="20" width="30" height="20" fill="black" stroke="black" stroke-width="2"/>
                        <rect x="15" y="15" width="20" height="10" fill="white" stroke="black" stroke-width="2"/>
                        <circle cx="25" cy="18" r="2" fill="black"/>
                        <rect x="18" y="25" width="2" height="10" fill="white"/>
                        <rect x="22" y="25" width="2" height="10" fill="white"/>
                        <rect x="26" y="25" width="2" height="10" fill="white"/>
                        <rect x="30" y="25" width="2" height="10" fill="white"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- パスワード変更 -->
        <div class="account-item" wire:click="openPasswordModal">
            <div class="account-item-content">
                <div class="account-item-title">パスワード変更</div>
                <div class="account-item-icon">
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <circle cx="25" cy="25" r="18" fill="none" stroke="black" stroke-width="4"/>
                        <rect x="20" y="22" width="10" height="6" fill="black"/>
                        <circle cx="25" cy="28" r="2" fill="white"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- ログアウト -->
        <div class="account-item" wire:click="logout" wire:confirm="ログアウトしますか？">
            <div class="account-item-content">
                <div class="account-item-title">ログアウト</div>
                <div class="account-item-icon">
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <path d="M10 10 L35 10 L35 40 L10 40 Z" fill="none" stroke="black" stroke-width="3"/>
                        <path d="M25 25 L45 25 M40 20 L45 25 L40 30" fill="none" stroke="black" stroke-width="3"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- 名前変更モーダル -->
    @if($showNameModal)
        <div class="modal-overlay" wire:click="closeNameModal">
            <div class="modal-content" wire:click.stop>
                <h3>名前変更</h3>
                <form wire:submit.prevent="updateName">
                    <div class="form-group">
                        <label for="username">ユーザー名</label>
                        <input type="text" id="username" wire:model="username" class="form-input">
                        @error('username') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-buttons">
                        <button type="button" wire:click="closeNameModal" class="btn-cancel">キャンセル</button>
                        <button type="submit" class="btn-submit">変更</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- 学年変更モーダル -->
    @if($showYearModal)
        <div class="modal-overlay" wire:click="closeYearModal">
            <div class="modal-content" wire:click.stop>
                <h3>学年変更</h3>
                <form wire:submit.prevent="updateYear">
                    <div class="form-group">
                        <label for="year">学年</label>
                        <select id="year" wire:model="year" class="form-input">
                            <option value="1">1年生</option>
                            <option value="2">2年生</option>
                            <option value="3">3年生</option>
                        </select>
                        @error('year') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-buttons">
                        <button type="button" wire:click="closeYearModal" class="btn-cancel">キャンセル</button>
                        <button type="submit" class="btn-submit">変更</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- パスワード変更モーダル -->
    @if($showPasswordModal)
        <div class="modal-overlay" wire:click="closePasswordModal">
            <div class="modal-content" wire:click.stop>
                <h3>パスワード変更</h3>
                <form wire:submit.prevent="updatePassword">
                    <div class="form-group">
                        <label for="current_password">現在のパスワード</label>
                        <input type="password" id="current_password" wire:model="current_password" class="form-input">
                        @error('current_password') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_password">新しいパスワード</label>
                        <input type="password" id="new_password" wire:model="new_password" class="form-input">
                        @error('new_password') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">新しいパスワード（確認）</label>
                        <input type="password" id="new_password_confirmation" wire:model="new_password_confirmation" class="form-input">
                    </div>
                    <div class="modal-buttons">
                        <button type="button" wire:click="closePasswordModal" class="btn-cancel">キャンセル</button>
                        <button type="submit" class="btn-submit">変更</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <style>
    .account-container {
        padding: 20px;
        max-width: 400px;
        margin: 0 auto;
        min-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }

    .account-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .account-item {
        background-color: white;
        border: 2px solid #ddd;
        border-radius: 15px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .account-item:hover {
        background-color: #f8f9fa;
        border-color: #ceafaf;
    }

    .account-item-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .account-item-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .account-item-icon {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
    }

    .modal-content h3 {
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .form-input:focus {
        outline: none;
        border-color: #ceafaf;
    }

    .error {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn-cancel {
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
    }

    .btn-submit {
        padding: 10px 20px;
        background-color: #ceafaf;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #bf9e9e;
    }

    /* ログアウトアイテム専用スタイル */
    .account-item:last-child {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    .account-item:last-child:hover {
        background-color: #ffe6e6;
        border-color: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
    }

    .account-item:last-child .account-item-title {
        color: #dc3545;
    }

    .account-item:last-child .account-item-icon svg {
        transition: transform 0.3s ease;
    }

    .account-item:last-child:hover .account-item-icon svg {
        transform: scale(1.1);
    }
    </style>
</div>
