<div x-data="{retention: 0, type: 0}" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit video: {{ $video->title }}({{$video->tag}})</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" wire:model="video.title">
                </div>
                <div class="form-group">
                    <label for="tag">Tag</label>
                    <input type="text" disabled class="form-control" id="tag" value="{{ $video->tag }}" >
                </div>
                <div class="form-group">
                    <label for="tag">Custom link</label>
                    <input type="text" disabled class="form-control" id="slug" value="Coming soon">
                </div>
                <div class="form-group">
                    <label for="tag">Retention policy  <input class="form-check-input" x-model="retention" type="checkbox">
                        <label class="form-check-label" for="gridCheck">
                            Enable
                        </label></label>
                    <div x-show="retention == 1" class="input-group">
                        <input x-show="type == 0" type="text" class="form-control input-sm"/>
                        <input x-show="type == 1" type="date" class="form-control input-sm"/>
                        <span class="input-group-btn" style="width:0px;"></span>
                        <select @change="type = $event.target.value" class="form-control">
                            <option value="0">Views</option>
                            <option value="1">Date</option>
                        </select>
                    </div>
                    <small x-show="retention == 1">Delete video automatically on a specific date or after x amount of views</small>
                </div>
                <div class="form-group pt-4">
                    <h4>Debug info</h4>
                </div>
                <div class="form-group">
                    <label for="tag">Hash</label>
                    <input type="text" disabled class="form-control" id="hash" value="{{ $video->original }}" >
                </div>
                <div class="form-group">
                    <label for="tag">Stream hash</label>
                    <input type="text" disabled class="form-control" id="streamhash" value="{{ $video->streamhash }}" >
                </div>
                <div class="form-group">
                    <label for="tag">Video info</label>
                    <textarea class="form-control">
                        {{ $info }}
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="tag">Created at</label>
                    <input type="text" disabled class="form-control" id="streamhash" value="{{ $video->created_at }}" >
                    <label for="tag">Updated at</label>
                    <input type="text" disabled class="form-control" id="streamhash" value="{{ $video->updated_at }}" >

                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" wire:click.prevent="update()" data-dismiss="modal" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</div>
