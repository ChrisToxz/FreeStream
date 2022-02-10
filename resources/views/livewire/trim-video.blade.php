
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

            <video src="{{ asset('/storage/videos/'.$video->tag.'/'.$video->EditableVideo) }}"></video>
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
            <button type="button" wire:click.prevent="trim()"  class="btn btn-primary">Save changes</button>
        </div>

        <script>
            $( function() {

                // var start = new Date($( "#slider-range" ).slider( "values", 0 ) * 1000).toISOString().substr(11, 8);
                // var end = new Date($( "#slider-range" ).slider( "values", 1 ) * 1000).toISOString().substr(11, 8);
                $( "#slider-range" ).slider({
                    range: true,
                    min: 0,
                    max: {{ $video->info->duration }},
                    values: [ 0, {{ $video->info->duration }} ],
                    slide: function( event, ui ) {
                        var start = new Date(ui.values[0] * 1000).toISOString().substr(11, 8);
                        var end = new Date(ui.values[1] * 1000).toISOString().substr(11, 8);
                        $( "#amount" ).text( "Start " + start + " - End " + end );
                        var duration = new Date((ui.values[1]-ui.values[0]) * 1000).toISOString().substr(11,8);
                        $( "#duration" ).text("New duration: " + duration);
                    }
                });
                var start = new Date($( "#slider-range" ).slider( "values", 0 ) * 1000).toISOString().substr(11, 8);
                var end = new Date($( "#slider-range" ).slider( "values", 1 ) * 1000).toISOString().substr(11, 8);
                $( "#amount" ).text( "Start " + start + " - End " + end );
            } );
        </script>
    </div>
</div>
