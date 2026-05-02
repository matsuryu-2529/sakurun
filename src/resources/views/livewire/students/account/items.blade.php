<div class="account-items">
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
