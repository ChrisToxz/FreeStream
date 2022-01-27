{{-- TODO: a href links--}}
    <div class="card shadow-lg">
        <a href="http://localhost/v/{{$video->tag}}">
            <img class="card-img-top" style="    width: 100%; height: 15vw; object-fit: cover;" src="{{ asset('/storage/videos/'.$video->tag.'/thumb.jpg') }}" alt="Thumbnail"></a>
        <div class="card-body">
            <h5 class="card-title">
                {{ $video->title }}
                @if($video->type == 1)
                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="Original file" class="bi-file-play"></i>
                @elseif($video->type == 2)
                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="x264 (Web)" class="bi-cloud"></i>
                @elseif($video->type == 3)
                    <small data-bs-toggle="tooltip" data-bs-placement="top" title="x264 + HLS"><i class="bi-cast"></i></small>
                @endif
                <small class="text-muted float-end">00:00</small>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($video->created_at)->diffForHumans() }} <small class="text-muted float-end">0 MB - {{$video->views->count()}} views</small></h6>

{{--            <p class="text-center">--}}
{{--            <div class="progress">--}}
{{--                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%"><span class="justify-content-center d-flex position-absolute w-100 text-dark">Processing video - 100%</span></div>--}}
{{--            </div>--}}
{{--            </p>--}}
            <p class="card-text">
                <button class="btn btn-sm btn-outline-info bi-clipboard" onclick="copy('http://localhost/v/{{$video->tag}}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Tag: {{$video->tag}}"> Copy link</button>
                <button class="btn btn-sm btn-outline-primary bi-cloud-download" data-bs-toggle="tooltip" data-bs-placement="top" title="Tag: {{$video->tag}}"> Download</button>
                <button class="btn btn-sm btn-outline-secondary bi-pencil-fill" wire:click="$emit('showModal', 'edit-video', '{{ $video->tag }}')"> Edit</button>
                <button type="button" class="btn btn-sm btn-outline-danger bi-trash-fill" id="button" value="delete"> Delete</button>
            </p>
        </div>
    </div>


