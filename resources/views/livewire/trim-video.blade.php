<div x-data="" class="modal-dialog modal-xl">

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Trim video: {{$video->title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


            @if(!$video->original && $video->type == 3)
                No trimming possible due missing original or editable file.
            @else

                <video-js id=vid1 width=600 height=300 class="vjs-default-skin" controls>\
                    @if($video->type == 1)
                        <source
                            src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->original) }}"
                            type="video/mp4">
                    @elseif($video->type == 2)
                        <source
                            src="{{ asset('/storage/videos/'.$video->tag.'/stream/'.$video->streamhash) }}"
                            type="video/mp4">
                    @endif
                    <source
                        src="{{ asset('/storage/videos/'.$video->tag.'/stream/'.$video->streamhash) }}"
                        type="application/x-mpegURL">
                </video-js>

                @error('start') <span class="error">{{ $message }}</span> @enderror
                @error('end') <span class="error">{{ $message }}</span> @enderror

            <style>
                /* Supress pointer events */
                #slider-range { pointer-events: none; }
                /* Enable pointer events for slider handle only */
                #slider-range .ui-slider-handle { pointer-events: auto; }
            </style>
            <form class="row justify-content-md-center mt-3">
                    <div class="col-md-10">
                        <span class="text-black" id="amount"></span>
                        <span class="text-body float-end" id="duration"></span>
                        <div class="mt-1" id="slider-range"></div>
                    </div>
            </form>

                @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" wire:click.prevent="trim()"  class="btn btn-primary">Trim video</button>
        </div>


        <script>

        </script>
        <script>

            $( function() {
                var player = videojs('vid1',{
                    fluid: true
                });
                player.on('timeupdate', onVideoTimeupdate );

                function onVideoTimeupdate() {
                    var loopStart = parseFloat($( "#slider-range" ).slider( "values", 0 ));
                    var loopEnd = parseFloat($( "#slider-range" ).slider( "values", 1 ));

                        if (player.currentTime() < loopStart || player.currentTime() >= loopEnd ) {
                            player.currentTime(loopStart);
                        }
                    }

                $( "#slider-range" ).slider({
                    range: true,
                    min: 0,
                    max: {{ $video->info->duration }},
                    values: [ 0, {{ $video->info->duration }} ],
                    slide: function( event, ui ) {
                        var start = new Date(ui.values[0] * 1000).toISOString().substr(11, 8);
                        var end = new Date(ui.values[1] * 1000).toISOString().substr(11, 8);
                        var duration = new Date((ui.values[1]-ui.values[0]) * 1000).toISOString().substr(11,8);

                        $( "#amount" ).text( "Start " + start + " - End " + end );
                        $( "#duration" ).text("New duration: " + duration);

                        player.currentTime(ui.values[ui.handleIndex]);
                        videojs.createTimeRange(ui.values[0],ui.values[1])
                    }
                });
                var start = new Date($( "#slider-range" ).slider( "values", 0 ) * 1000).toISOString().substr(11, 8);
                var end = new Date($( "#slider-range" ).slider( "values", 1 ) * 1000).toISOString().substr(11, 8);
                $( "#amount" ).text( "Start " + start + " - End " + end );
            } );
        </script>
    </div>
</div>
