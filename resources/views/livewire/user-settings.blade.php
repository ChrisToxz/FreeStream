<div x-data="" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">User settings</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @error('username') <span class="error">{{ $message }}</span> @enderror
            @error('password') <span class="error">{{ $message }}</span> @enderror
            <form>
                <div class="form-group">
                    <label for="title">Username</label>
                    <input type="text" class="form-control" id="username" wire:model="username">
                </div>
                <div class="form-group">
                    <label for="tag">Password (keep blank if you don't want to change it)</label>
                    <input type="password" class="form-control" id="password" wire:model="password">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" wire:click.prevent="update()" data-dismiss="modal" class="btn btn-primary">Save user settings</button>
        </div>
    </div>
</div>
