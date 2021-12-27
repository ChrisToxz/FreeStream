@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="card text-center">
                <div class="card-body">
                    <p><video controls autoplay muted loop >
                            <source src="{{ asset('/storage/videos/'.$video->file) }}" type="video/mp4">
                            Your browser does not support HTML video.
                        </video>
                    </p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-3">
                            {{ $video->created_at }}
                        </div>
                        <div class="col-md-6">
                            {{ $video->title }}
                        </div>
                        <div class="col-md-3">
                            {{  $video->views()->count() }} views
                        </div>
                    </div>
                </div>
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
