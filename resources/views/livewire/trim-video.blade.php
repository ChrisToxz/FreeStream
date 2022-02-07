<div x-data="" class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Trim video: {{$video->title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if(!$video->original && $video->type == 3)
                No trimming possible due missing original or editable file.
            @else

            <video src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->EditableVideo) }}"></video>
            <form class="row">
                    <div class="col-md-6">
                        <label for="title" class="form-label float-start">Trim start</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="title" class="form-label float-start">Trim end</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="customRange1" class="form-label">Trimming range</label>
                        <input type="range" class="form-range" id="customRange1">
                    </div>
            </form>
                @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" wire:click.prevent="trim()"  class="btn btn-primary">Save changes</button>
        </div>
    </div>
</div>
