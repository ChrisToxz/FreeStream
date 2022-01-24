
    <div class="card shadow-sm">
        <a href="http://localhost/v/">
            <img class="card-img-top" style="    width: 100%; height: 15vw; object-fit: cover;" src="{{ asset('/storage/videos/'.$video->tag.'/thumb.jpg') }}" alt="Thumbnail"></a>
        <div class="card-body">
            <h5 class="card-title">
                <small data-bs-toggle="tooltip" data-bs-placement="top" title="x264 + HLS"><i class="bi-cast"></i></small> - {{ $video->title }}
                <small class="text-muted float-end">00:00</small>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">5 Minutes ago</h6>

{{--            <p class="text-center">--}}
{{--            <div class="progress">--}}
{{--                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%"><span class="justify-content-center d-flex position-absolute w-100 text-dark">Processing video - 100%</span></div>--}}
{{--            </div>--}}
{{--            </p>--}}
            <p class="card-text">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tag: {{$video->tag}}">Copy link</button>
                <button class="btn btn-sm btn-outline-secondary" >Edit</button>
                <button type="button" class="btn btn-sm btn-outline-danger" id="button" value="delete">Delete</button>
                <small class="text-muted float-end">0 MB - 0 views</small>
            </p>
        </div>
    </div>


