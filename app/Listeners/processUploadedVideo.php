<?php

namespace App\Listeners;

use App\Events\videoUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class processUploadedVideo
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
     * @param  object  $event
     * @return void
     */
    public function handle(videoUploaded $event)
    {

//        $media = FFMpeg::fromDisk('videos')->open($event->video->OriginalPath);
//        $media->getFrameFromSeconds(0.1)->export()->toDisk('videos')->save($event->video->tag.'/thumb.jpg');

        //Generate secret stream hash
        $streamhash = Str::random(40);
        $event->video->streamhash = $streamhash;
        $event->video->save();
    }
}
