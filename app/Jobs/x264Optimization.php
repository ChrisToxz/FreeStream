<?php

namespace App\Jobs;

use App\Models\Video;
use App\SlipstreamSettings;
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

    public $video, $HLS, $settings;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video, $HLS = 0, )
    {
        $this->video = $video;
        $this->HLS = $HLS;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SlipstreamSettings $settings)
    {
        $this->settings = $settings->toCollection();
        // TODO: Qualities
        $qualities = [
            360 => [640, 360, $this->settings['streaming_bitrates'][360]],
            720 => [1280, 720, $this->settings['streaming_bitrates'][720]],
            1080 => [1920, 1080, $this->settings['streaming_bitrates'][1080]],
            1440 => [2560, 1440, $this->settings['streaming_bitrates'][1440]],
            2160 => [3840, 2160, $this->settings['streaming_bitrates'][2160]]
        ];
        $streamhash = Str::random(40);

        // Bitrates // TODO: Bitrates list
        $originalBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(round($this->video->info->bit_rate/1000,0)); // 360

        $superLowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500); // 360
        $lowBitrateFormat =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(100720); // 720
        $midBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(101080); // 1080
        $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(101440); // 1440

        if(!$this->HLS){
            FFMpeg::fromDisk('videos')->open($this->video->OriginalPath)
                ->export()->onProgress(function ($percentage) {

                })->toDisk('videos')->inFormat($originalBitrateFormat)->save($this->video->tag.'/'.$streamhash.'.mp4');

            $this->video->streamhash = $streamhash.'.mp4';
            $this->video->save();
        }else{
            // init
            $ff = FFMpeg::fromDisk('videos')
                ->open($this->video->OriginalPath)
                ->exportForHLS()
                ->setSegmentLength(10) // optional
                ->setKeyFrameInterval(48); // optional

            foreach($qualities as $quality){
                if($this->video->info->height >= $quality[1]){
                    $ff->addFormat((new X264('libmp3lame', 'libx264'))->setKiloBitrate($quality[2]), function ($media) use ($quality){
                        $media->scale($quality[0], $quality[1]);
                    });
                }
            }
//            $ff->addFormat((new X264('libmp3lame', 'libx264'))->setKiloBitrate($qualities[360][2]), function($media) use ($qualities){
//                $media->scale($qualities[360][0], $qualities[360][1]);
//            });
//            $ff->addFormat((new X264('libmp3lame', 'libx264'))->setKiloBitrate($qualities[720][2]), function($media) use ($qualities){
//                $media->scale($qualities[720][0], $qualities[720][1]);
//            });
            //loop
//            foreach($qualities as $quality){
//                if($quality[0] < $this->video->info->height){
//                    $ff->addFormat((new X264('libmp3lame', 'libx264'))->setKiloBitrate($quality[2]), function($media) use ($quality){
//                        $media->scale($quality[0], $quality[1]);
//                    });
//                }
//            }

//                $ff->addFormat($superLowBitrateFormat, function($media) {
//                    $media->scale(640, 360);
//                });
//                ->addFormat($lowBitrateFormat, function($media) {
//                    $media->scale(1280, 720);
//                })
//                ->addFormat($midBitrateFormat, function($media) {
//                $media->scale(1920, 1080);;
//                })
//                ->addFormat($highBitrateFormat, function($media) {
//                $media->scale(2560, 1440);
//                })
//

            $ff->useSegmentFilenameGenerator(function ($name, $format, $key, callable $segments, callable $playlist) {
                    $segments("{$name}-{$format->getKiloBitrate()}-{$key}-%03d.ts");
                    $playlist("{$name}-{$format->getKiloBitrate()}-{$key}.m3u8");
                })
                ->toDisk('videos')->save($this->video->tag.'/'.$streamhash.'.m3u8');

            $this->video->streamhash = $streamhash.'.m3u8';
            $this->video->save();
        }

    }
}
