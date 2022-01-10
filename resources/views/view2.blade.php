@extends('layouts.app')

@section('content')
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
    <link href="https://www.unpkg.com/videojs-hls-quality-selector@1.0.5/dist/videojs-hls-quality-selector.css" rel="stylesheet" />

    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="https://unpkg.com/@videojs/http-streaming@2.13.1/dist/videojs-http-streaming.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-quality-levels/2.1.0/videojs-contrib-quality-levels.min.js" integrity="sha512-IcVOuK95FI0jeody1nzu8wg/n+PtQtxy93L8irm+TwKfORimcB2g4GSHdc0CvsK8gt1yJSbO6fCtZggBvLDDAQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.unpkg.com/videojs-hls-quality-selector@1.0.5/dist/videojs-hls-quality-selector.min.js"></script>



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
{{--                        <video preload="none" id="player" autoplay controls crossorigin>--}}
{{--                            <source type="application/x-mpegURL" src="">--}}
{{--                        </video>--}}
                        <video-js id=vid1 width=600 height=300 class="vjs-default-skin" controls>
                            <source
                                src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->files->m3u8) }}"
                                type="application/x-mpegURL">
                        </video-js>

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
    <script>
        var player = videojs('vid1',{
            fluid: true
        });
        player.hlsQualitySelector();
        player.play();
    </script>

@endsection
