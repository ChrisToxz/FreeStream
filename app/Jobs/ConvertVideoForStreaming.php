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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
        $this->prepareStatus();
        $this->video = $video;
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



        $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(250);
        $midBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
        $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);

        FFMpeg::fromDisk('videos')->open($this->video->file)
//            ->resize(960,540)
            ->export()->onProgress(function ($percentage) {
                $this->setProgressNow($percentage/3);
            })->toDisk('videos')->inFormat($lowBitrateFormat)->save($this->video->tag.'/low-'.$this->video->streamfile);

        FFMpeg::fromDisk('videos')->open($this->video->file)
//            ->resize(960,540)
            ->export()->onProgress(function ($percentage) {
                $this->setProgressNow($percentage/3);
            })->toDisk('videos')->inFormat($midBitrateFormat)->save($this->video->tag.'/mid-'.$this->video->streamfile);

        FFMpeg::fromDisk('videos')->open($this->video->file)
//            ->resize(960,540)
            ->export()->onProgress(function ($percentage) {
                $this->setProgressNow($percentage/3);
            })->toDisk('videos')->inFormat($highBitrateFormat)->save($this->video->tag.'/high-'.$this->video->streamfile);

        $path = public_path("storage/videos/".$this->video->tag."/low-".$this->video->streamfile);
        $getID3 = new \getID3;
        $data = $getID3->analyze($path);
        Log::info('2');
        Log::info($data);
        $this->video->streamsize = $data['filesize'];
        $this->video->save();

    }
}