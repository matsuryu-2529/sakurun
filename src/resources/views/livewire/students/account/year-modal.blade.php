@if ($showYearModal)
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
