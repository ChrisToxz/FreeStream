<div class="row">
    <a class="dropdown-item px-4 text-center" wire:click="$emit('showModal', 'user-settings')">Click here for user settings</a>
    <div class="col-md-3 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <span class="font-weight-bold">Powered by</span>
            <img class="" width="150px" src="{{ asset('logo.svg') }}">
            <span class="text-black-50">Version: xx</span>
        </div>
    </div>
    <div class="col-md-5 border-right">
        <div class="p-3 pt-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h4 class="text-right">General settings</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="labels">Sitename</label>
                    <input type="text" class="form-control" placeholder="Sitename" wire:model="settings.site_name">
                    <span class="text-small text-muted">The name that your guests will see</span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 mt-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="" wire:model="settings.keep_original_file">
                        <label class="form-check-label" for="">Keep original file</label>
                    </div>
                    <span class="text-small text-muted">Keep uploaded file on disk, when using web optimization processing the original and optimized files will be stored.</span>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="" wire:model="settings.guests_can_see_video_info">
                        <label class="form-check-label" for="">Guests can see video info</label>
                    </div>
                    <span class="text-small text-muted">This includes upload date, size, amount of views</span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12"><label class="labels">Views retention delay in minutes</label>
                    <input type="number" class="form-control" placeholder="minutes" wire:model="settings.view_retention_delay">
                    <span class="text-small text-muted">This will be added on top of the default timeout, the length of the video.<br>Advised to add at least a few minutes as extra buffer</span>
                </div>
            </div>
            <div class="row mt-3">
                <span class=""><h4 class="text-right">Streaming bitrate settings in kb/s (x264/HLS)</h4></span>
                <div class="col-md-4"><label class="labels">360p</label>
                    <input type="number" class="form-control" placeholder="minutes" wire:model="settings.streaming_bitrates.360">
                    <span class="text-small text-muted"></span>
                </div>
                <div class="col-md-4"><label class="labels">720p</label>
                    <input type="number" class="form-control" placeholder="minutes" wire:model="settings.streaming_bitrates.720">
                    <span class="text-small text-muted"></span>
                </div>
                <div class="col-md-4"><label class="labels">1080p</label>
                    <input type="number" class="form-control" placeholder="minutes" wire:model="settings.streaming_bitrates.1080">
                    <span class="text-small text-muted"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4"><label class="labels">1440p</label>
                    <input type="number" class="form-control" placeholder="minutes" wire:model="settings.streaming_bitrates.1440">
                    <span class="text-small text-muted"></span>
                </div>
                <div class="col-md-4"><label class="labels">2160p</label>
                    <input type="number" class="form-control" placeholder="minutes" wire:model="settings.streaming_bitrates.2160">
                    <span class="text-small text-muted"></span>
                </div>
            </div>
            <div class="row mt-3">

            </div>
            <div class="mt-5 text-center">
                <button class="btn btn-primary" wire:click.prevent="update()" type="button">Save Settings</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center experience">
                <span>System information</span>
                <span class="border px-3 p-1 add-experience"><i class="bi-plus"></i>&nbsp;IP?</span></div><br>
            <div class="col-md-12">
                <span>Total videos:</span>
            </div>
            <div class="col-md-12">
                <span>Total views:</span>
            </div>
            <div class="col-md-12">
                <span>Total etc:</span>
            </div>
        </div>
    </div>
</div>
