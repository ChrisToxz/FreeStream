<div
    x-data="{ isUploading: false, isFinished: false, progress: 0 , file: ''}"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false, isFinished = true"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>

    <div class="col-lg-6 offset-lg-3" >
    <!-- File Input -->

        <div class="row justify-content-center">
            <div x-show="!file">
            <input type="file" wire:model="video"  id="file" style="display: none;" x-ref="file" @change="file = $refs.file.files[0].name">
            <button type="button" class="btn btn-outline-dark" onclick="document.getElementById('file').click();">Select video</button>
            </div>

                @error('video') <span class="error">{{ $message }}</span> @enderror


            <div x-show="file">
                <div class="col-md-12 py-lg-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="title">Title</span>
                        <input type="text" class="form-control" x-bind:value="file" wire:model="title">
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm">
                            <option selected>Upload method</option>
                            <option value="1">Original file - Keep file as it is</option>
                            <option value="2">X264 - Optimized for web</option>
                            <option value="3">Streamable - HLS Stream protocol</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
{{--    <div class="form-switch">--}}
{{--        <input class="form-check-input" type="checkbox" wire:model="streamable" id="streamable">--}}
{{--        <label class="form-check-label" for="streamable">Make streamable</label>--}}
{{--    </div>--}}


    <!-- Progress Bar -->
    <div x-show="isUploading">
        Uploading...<br \>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" x-bind:style="`width: ${progress}%`"></div>
        </div>
    </div>

    <div x-show="isFinished">

        <button wire:click="save" class="btn btn-outline-primary">Save!</button>
        <button x-on:click="file = '', isFinished = 0" class="btn btn-outline-danger">Reset</button>
    </div>
    </div>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</div>
