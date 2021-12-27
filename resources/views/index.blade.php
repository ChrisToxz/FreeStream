@extends('layouts.app')

@section('content')
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ config('app.name') }}</h1>
                <p class="lead text-muted">Simple, quick & opensource</p>
                <p>
                    <form method="POST" enctype="multipart/form-data" id="video" action="javascript:void(0)" >
                        <label class="form-label" for="file">Video upload</label>
                        <input type="file" class="form-control" name="file" id="file" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach ($videos as $video)
                <div class="col">
                    <div class="card shadow-sm">
                        <a href="{{ url('/v/'.$video->tag) }}">
                            <img class="card-img-top" src="{{ asset('/storage/thumbs/'.$video->tag.'.jpg') }}" alt="Card image cap">
                        </a>
                        <div class="card-body">
                            <p class="card-text">{{ $video->title }}  <small class="text-muted">{{ $video->duration_string }}</small></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                                <small class="text-muted">{{ round(($video->filesize/1000000),2) }} MB - {{ $video->views()->count() }} views</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#video').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('upload')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        this.reset();
                        alert('File has been uploaded successfully');
                        console.log(data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection
