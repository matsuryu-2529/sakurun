@if ($showNameModal)
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
