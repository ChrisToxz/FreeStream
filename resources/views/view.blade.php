@extends('layouts.app')

@section('content')
    <script src="https://unpkg.com/plyr@3.6.12/dist/plyr.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.12/plyr.css" />


    <div class="album py-5 bg-light">
        <div class="container">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    {{ $video->title }}
                </div>
                <div class="card-body">
                    <p>
                        {{--                        <video controls crossorigin playsinline poster="{{ asset('/storage/thumbs/'.$video->tag.'.jpg') }}">--}}
                        {{--                            <source src="{{ asset('/storage/videos/'.$video->file) }}" type="video/mp4" size="1080">--}}
                        {{--                            <!-- Fallback for browsers that don't support the <video> element -->--}}
                        {{--                            <a href="{{ asset('/storage/videos/'.$video->file) }}" download>Download</a>--}}
                        {{--                        </video>
                        --}}
                        <video  preload="none" id="player" autoplay controls crossorigin style="max-width: 100%;" poster="{{ asset('/storage/videos/'.$video->tag.'/thumb.jpg') }}">
                            <source  src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->files->mp4) }}">
                        </video>

                        {{--                        <video controls autoplay muted loop >--}}
                        {{--                            <source src="{{ asset('/storage/videos/'.$video->file) }}" type="video/mp4">--}}
                        {{--                            Your browser does not support HTML video.--}}
                        {{--                        </video>--}}
                    </p>

                </div>
                <div class="card-footer">
                    <span class="float-end">
                        <a href="" class="btn btn-sm btn-outline-secondary" id="button" value="edit">Edit</a>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="button" value="delete">Delete</button>
                    </span>
                </div>
            </div>
            </div>
        </div>

@endsection
