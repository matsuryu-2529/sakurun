@if ($showPasswordModal)
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
