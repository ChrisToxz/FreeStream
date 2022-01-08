<div wire:poll.750ms class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="results">
    @foreach($videos as $video)
        <div class="col" id="rBEX"
             x-data="{ isReady: {{ $video->job->is_finished }} }">
            <div class="card shadow-sm h-100">
                <a href="http://localhost/v/{{ $video->tag }}">
                    <img class="card-img-top" style="    width: 100%; height: 15vw; object-fit: cover;" src="{{ asset('/storage/videos/'.$video->tag.'/thumb.jpg') }}" alt="Thumbnail"></a>
                <div class="card-body">
                    <h5 class="card-title">{{ $video->title }} <small class="text-muted"> - 00:00</small> <small class="text-muted float-end">Tag: {{ $video->tag }}</small></h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</h6>

                        @if(!$video->job->is_finished)
                        <p class="text-center">
                            <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $video->progressnow }}%"><span class="justify-content-center d-flex position-absolute w-100 text-dark">Processing video - {{ $video->progressnow }}%</span></div>
                            </div>
                        </p>
                        @else
                            <p class="card-text">
                                <button class="btn btn-sm btn-outline-secondary" id="button" value="edit">Edit</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="button" value="delete">Delete</button>
                                <small class="text-muted float-end" >0 MB - 0 views</small>
                            </p>
                        @endif

                </div>
            </div>
        </div>
    @endforeach
</div>
