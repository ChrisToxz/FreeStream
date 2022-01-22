<div>
    <section class="py-sm-0 text-center container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <p class="text-center">
                <div class="col-lg-12" >
                    <!-- File Input -->
                    <form wire:submit.prevent="upload">
                        <div class="row justify-content-center">
                                @error('video') <span class="error">{{ $message }}</span> @enderror
                                <input type="file" wire:model="video"  id="file" style="display: none;" x-ref="file" @change="file = $refs.file.files[0].name">
                                <button type="button" class="btn btn-outline-dark" onclick="document.getElementById('file').click();">Select video</button>
                        </div>
                        <button class="btn btn-outline-primary">Save!</button>
                    </form>
                    </p>
                </div>
            </div>
    </section>
</div>
