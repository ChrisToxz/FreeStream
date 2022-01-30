<div wire:poll.100ms>
    <p class="text-center">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $video->job->progress_now }}%"><span
                class="justify-content-center d-flex position-absolute w-100 text-dark">Processing video - {{ $video->job->progress_now }}%</span></div>
    </div>
    </p>
</div>
