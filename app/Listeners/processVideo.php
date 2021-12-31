<?php

namespace App\Listeners;

use App\Events\videoUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

        $media = FFMpeg::fromDisk('public')->open('videos/IXAe-1640974459HaSFMH3n1lgfLbLhUsnadTjy6fs18XEo4Q0D3WIb.mp4');
        $save = $media->getFrameFromSeconds(0.1)->export()->toDisk('public')->save('thumbs/test.jpg');

       // (new VideoThumbnail)->createThumbnail($path, public_path('storage/thumbs/'), $event->video->tag.'.jpg', 1, 1920, 1080);
        $media = FFMpeg::fromDisk('public')->open('videos/IXAe-1640974459HaSFMH3n1lgfLbLhUsnadTjy6fs18XEo4Q0D3WIb.mp4');
        $getID3 = new \getID3;
        $data = $getID3->analyze($path);
        $event->video->duration = $media->getDurationInMiliseconds();
        $event->video->filesize = '10';
        $event->video->video = json_encode($data["video"]);
        $event->video->save();
    }
}
