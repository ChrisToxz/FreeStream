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

        // TODO: Bitrates list + check how to get original bitrate
        $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);
        FFMpeg::fromDisk('videos')->open($this->video->OriginalPath)
            ->export()->onProgress(function ($percentage) {

            })->toDisk('videos')->inFormat($highBitrateFormat)->save($this->video->tag.'/'.$streamhash.'.mp4');

        $this->video->streamhash = $streamhash.'.mp4';
        $this->video->save();
    }
}
