@extends('layouts.app')

@section('content')
    <script src="https://unpkg.com/plyr@3.6.12/dist/plyr.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
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
                        <video preload="none" id="player" autoplay controls crossorigin>
                            <source type="application/x-mpegURL" src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->streamhash) }}.m3u8">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.querySelector('video');
            const source = video.getElementsByTagName("source")[0].src;
            const defaultOptions = {};


            if (!Hls.isSupported()) {
                video.src = source;
                var player = new Plyr(video, defaultOptions);
            } else {
                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                const hls = new Hls();
                hls.loadSource(source);

                // From the m3u8 playlist, hls parses the manifest and returns
                // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
                hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                    // Transform available levels into an array of integers (height values).
                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array

                    // Add new qualities to option
                    defaultOptions.quality = {
                        default: 0, //Default - AUTO
                        options: availableQualities,
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
                        var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })

                    // Initialize new Plyr player with quality options
                    var player = new Plyr(video, defaultOptions);
                });

                hls.attachMedia(video);
                window.hls = hls;
            }

            function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
                } else {
                    window.hls.levels.forEach((level, levelIndex) => {
                        if (level.height === newQuality) {
                            console.log("Found quality match with " + newQuality);
                            window.hls.currentLevel = levelIndex;
                        }
                    });
                }
            }
        });


        // (function () {
        //     var video = document.querySelector('#player');
        //
        //     if (Hls.isSupported()) {
        //         var hls = new Hls();
        //         hls.loadSource('https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8');
        //         hls.attachMedia(video);
        //         hls.on(Hls.Events.MANIFEST_PARSED,function() {
        //             video.play();
        //         });
        //     }
        //
        //     plyr.setup(video);
        // })();
    </script>
@endsection
