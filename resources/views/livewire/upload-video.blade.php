<div
    x-data="{ isUploading: false, isFinished: false, progress: 0 }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false, isFinished = true"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>

    <form>
    <!-- File Input -->
    <input type="file" wire:model="video">
    @error('video') <span class="error">{{ $message }}</span> @enderror

    <div class="form-switch">
        <input class="form-check-input" type="checkbox" wire:model="streamable" id="streamable">
        <label class="form-check-label" for="streamable">Make streamable</label>
    </div>


    <!-- Progress Bar -->
    <div x-show="isUploading">
        Uploading...<br \>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" x-bind:style="`width: ${progress}%`"></div>
        </div>
    </div>

    <div x-show="isFinished">
        <button wire:click="save" class="btn btn-outline-primary">Save!</button>
    </div>
    </form>
</div>
