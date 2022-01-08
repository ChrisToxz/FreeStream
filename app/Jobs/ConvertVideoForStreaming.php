<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->prepareStatus(['video_tag' => $video->tag]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // trackable job
        $this->setProgressMax(100);
        //stream
        $superLowBitrate = (new X264)->setKiloBitrate(100360);
        $lowBitrate = (new X264)->setKiloBitrate(100720);
        $midBitrate = (new X264)->setKiloBitrate(101080);
        $highBitrate = (new X264)->setKiloBitrate(101440);
        $superHighBitrate = (new X264)->setKiloBitrate(102160);

        FFMpeg::fromDisk('videos')
            ->open($this->video->OriginalPath)
            ->exportForHLS()
            ->onProgress(function ($percentage) {
                $this->setProgressNow($percentage);
            })
            ->setSegmentLength(10) // optional
            ->setKeyFrameInterval(48) // optional
            ->addFormat($superLowBitrate, function($media) {
                $media->scale(640, 360);
            })
            ->addFormat($lowBitrate, function($media) {
                $media->scale(1280, 720);
            })
            ->addFormat($midBitrate, function($media) {
                $media->scale(1920, 1080);;
            })
            ->addFormat($highBitrate, function($media) {
                $media->scale(2560, 1440);
            })
            ->addFormat($superHighBitrate, function($media) {
                $media->scale(3840, 2160);
            })
            ->useSegmentFilenameGenerator(function ($name, $format, $key, callable $segments, callable $playlist) {
                $segments("{$name}-{$format->getKiloBitrate()}-{$key}-%03d.ts");
                $playlist("{$name}-{$format->getKiloBitrate()}-{$key}.m3u8");
            })
            ->toDisk('videos')->save($this->video->tag.'/'.$this->video->streamhash.'.m3u8');

    }
}
