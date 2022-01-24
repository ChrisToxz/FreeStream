<div class="row">
    @foreach($videos as $video)
        <div class="col-md-4 gy-4">
            <x-video-card :video="$video"/>
        </div>
    @endforeach
</div>
