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
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class x264Optimization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video, $HLS;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video, $HLS = 0)
    {
        $this->video = $video;
        $this->HLS = $HLS;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $streamhash = Str::random(40);

        // Bitrates // TODO: Bitrates list
        $superLowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(100); // 360
        $lowBitrateFormat =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(100720); // 720
        $midBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(101080); // 1080
        $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(101440); // 1440

        if(!$this->HLS){
            FFMpeg::fromDisk('videos')->open($this->video->OriginalPath)
                ->export()->onProgress(function ($percentage) {

                })->toDisk('videos')->inFormat($highBitrateFormat)->save($this->video->tag.'/'.$streamhash.'.mp4');

            $this->video->streamhash = $streamhash.'.mp4';
            $this->video->save();
        }else{
            FFMpeg::fromDisk('videos')
                ->open($this->video->OriginalPath)
                ->exportForHLS()
                ->setSegmentLength(10) // optional
                ->setKeyFrameInterval(48) // optional
                ->addFormat($superLowBitrateFormat, function($media) {
                    $media->scale(640, 360);
                })
                ->addFormat($lowBitrateFormat, function($media) {
                    $media->scale(1280, 720);
                })
                ->addFormat($midBitrateFormat, function($media) {
                $media->scale(1920, 1080);;
                })
                ->addFormat($highBitrateFormat, function($media) {
                $media->scale(2560, 1440);
                })            ->useSegmentFilenameGenerator(function ($name, $format, $key, callable $segments, callable $playlist) {
                    $segments("{$name}-{$format->getKiloBitrate()}-{$key}-%03d.ts");
                    $playlist("{$name}-{$format->getKiloBitrate()}-{$key}.m3u8");
                })
                ->toDisk('videos')->save($this->video->tag.'/'.$streamhash.'.m3u8');

            $this->video->streamhash = $streamhash.'.m3u8';
            $this->video->save();
        }

    }
}
