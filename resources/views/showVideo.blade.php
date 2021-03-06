@extends('layouts.video')

@section('title', $video->title)

@section('content')
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
    <link href="https://www.unpkg.com/videojs-hls-quality-selector@1.0.5/dist/videojs-hls-quality-selector.css" rel="stylesheet" />

    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="https://unpkg.com/@videojs/http-streaming@2.13.1/dist/videojs-http-streaming.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-quality-levels/2.1.0/videojs-contrib-quality-levels.min.js" integrity="sha512-IcVOuK95FI0jeody1nzu8wg/n+PtQtxy93L8irm+TwKfORimcB2g4GSHdc0CvsK8gt1yJSbO6fCtZggBvLDDAQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.unpkg.com/videojs-hls-quality-selector@1.0.5/dist/videojs-hls-quality-selector.min.js"></script>
    <div class="col-md-12 my-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <video-js id=vid1 width=600 height=300 class="vjs-default-skin" controls>\
                        @if($video->type == 1)
                            <source
                                src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->original) }}"
                                type="video/mp4">
                        @elseif($video->type == 2)
                            <source
                                src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->streamhash) }}"
                                type="video/mp4">
                        @endif
                        <source
                            src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->streamhash) }}"
                            type="application/x-mpegURL">
                    </video-js>

                    <h5 class="card-title mt-3">
                        @if($settings->guests_can_see_video_info)
                            {{ $video->title }}
                        <small data-bs-toggle="tooltip" data-bs-placement="top" title="x264 + HLS"><i class="bi-cast"></i></small>
                        <small class="text-muted float-end">
                            @if($video->info->duration > 3600)
                                {{ gmdate("H:i:s", $video->info->duration) }}
                            @else
                                {{ gmdate("i:s", $video->info->duration) }}
                            @endif
                        </small>
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($video->created_at)->diffForHumans() }} <small class="text-muted float-end">{{ $video->info->size }} MB -
                        {{ $video->views->count() }} views</small></h6></h6>
@endif
                    {{--            <p class="text-center">--}}
                    {{--            <div class="progress">--}}
                    {{--                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%"><span class="justify-content-center d-flex position-absolute w-100 text-dark">Processing video - 100%</span></div>--}}
                    {{--            </div>--}}
                    {{--            </p>--}}
                    <p class="card-text">

                    </p>
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
