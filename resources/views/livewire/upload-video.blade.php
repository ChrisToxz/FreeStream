<div
    x-data="{file: '', isUploading: false, isFinished: false, uploadProgress: 0, type: 1,   retention: false, retention_type: 1}"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false, isFinished = true"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="uploadProgress = $event.detail.progress"
>
    <section class="pt-3 text-center container">
        <div class="row">
            <div x-show="!file" class="col-md-8 mx-auto">
                <p class="text-center">
                <div class="col-lg-12" >
                    <!-- File Input -->
                    <form wire:submit.prevent="upload">
                        <div class="row justify-content-center" style="background-color: white;">
                                @error('video') <span class="error">{{ $message }}</span> @enderror
                                <input type="file" wire:model="video"  id="file" style="display: none;" x-ref="file" @change="file = $refs.file.files[0].name">
                                <button type="button" class="btn btn-outline-dark" onclick="document.getElementById('file').click();">Select video</button>
                        </div>
                    </form>
                    </p>
                </div>
            </div>
        <div x-show="file" class="container py-4" x-cloak>

            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label float-start">Title</label>
                                <input type="text" class="form-control" x-bind:placeholder="file" wire:model="title" id="title">
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label float-start">Processing method</label>
                                <select name="type" id="type" class="form-select" autocomplete="off" x-model="type" wire:model="type">
                                    <option value="">Select option</option>
                                    <option value="1" selected="selected">None (Original file)</option>
                                    <option value="2">Optimized for web (x264)</option>
                                    <option value="3">Optimized for streaming (x264/HLS)</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="col-4">
                                    <input class="form-check-input" type="checkbox" id="retention" value="1" x-model="retention" wire:model="retention">
                                    <label class="form-check-label float-start" for="retention">
                                        Enable retention policy
                                    </label>
                                </div>
                                <div x-show="retention">
                                <input class="form-control" id="value" x-bind:type="retention_type == 1 ? 'number' : 'datetime-local'" x-bind:placeholder="retention_type == 1 ? 'Amount of views' : 'Date'" wire:model="retention_value">
                                </div>
                            </div>
                            <div x-show="retention" class="col-6">
                                <label class="form-check-label float-start" for="retention_type">
                                    Retention type
                                </label>
                                <select name="retention_type" id="retention_type" class="form-select" x-model="retention_type" wire:model="retention_type">
                                    <option selected value="1">Views</option>
                                    <option value="2">Date</option>
                                </select>
                            </div>


                            <div x-show="isUploading">
                                Uploading...<br \>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" x-bind:style="`width: ${uploadProgress}%`"></div>
                                </div>
                            </div>
                            <div class="col-12" x-show="!isUploading">
                                <button wire:click.prevent="upload" class="btn btn-outline-primary">Save video!</button>.
                                <button x-on:click.prevent="file = '', isFinished = 0" id="reset" class="btn btn-outline-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script>

        window.addEventListener('resetform', event => {

            document.getElementById('reset').click()

        })

    </script>
</div>
