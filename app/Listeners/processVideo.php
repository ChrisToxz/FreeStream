<?php

namespace App\Listeners;

use App\Events\videoUploaded;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumb;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Dimensions;
use Pawlox\VideoThumbnail\VideoThumbnail;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class processVideo
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\videoUploaded  $event
     * @return void
     */
    public function handle(videoUploaded $event)
    {
        $path = public_path('storage/videos/'.$event->video->file);
        Log::info($path);



        // generate stream filename
        $streamhash = $event->video->tag.'-'.Str::random(40).'.mp4';
        $event->video->streamfile = $streamhash;

//        $getID3 = new \getID3;
//        $data = $getID3->analyze($path);
//
//        $event->video->size = $data['filesize'];
//        $event->video->duration = round($data['playtime_seconds'],2);
//
//        $json = [];
//        $json['resolution_x'] = $data['video']['resolution_x'];
//        $json['resolution_y'] = $data['video']['resolution_y'];
//        $event->video->video = json_encode($json);
        $event->video->save();



    }
}
