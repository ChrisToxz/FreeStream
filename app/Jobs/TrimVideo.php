<?php

namespace App\Jobs;

use App\Enums\VideoType;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Imtigger\LaravelJobStatus\Trackable;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class TrimVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    public $video, $start, $end;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video, $start, $end)
    {
        $this->video = $video;
        $this->start = $start;
        $this->end = $end;
        $this->prepareStatus(['video_id' => $video->id]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->setProgressMax(100);
        $new_hash = Str::random(40);
        $old_originalpath = $this->video->editableVideoPath;

        $start = \FFMpeg\Coordinate\TimeCode::fromSeconds($this->start);
        $duration = \FFMpeg\Coordinate\TimeCode::fromSeconds(($this->end - $this->start));

        $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start, $duration);

        $originalBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(round($this->video->info->bit_rate/1000,0)); // 360
        FFMpeg::fromDisk('videos')->open($old_originalpath)
            ->addFilter($clipFilter)
            ->export()->onProgress(function ($percentage) {
                $this->setProgressNow($percentage);
            })->toDisk('videos')->inFormat($originalBitrateFormat)->save($this->video->tag.'/stream/'.$new_hash.'.mp4');

        $this->video->streamhash = $new_hash.'.mp4';
        $this->video->type = VideoType::X264;
        $this->video->save();

        if($this->video->type != VideoType::Original){
            $files = \Storage::disk('videos')->files($this->video->tag.'/stream');
            $matchingFiles = preg_grep('/.*?'.mb_substr($this->video->streamhash, 0, -5).'?/', $files);
            foreach($matchingFiles as $file){
                \Storage::disk('videos')->delete($file);
            }
            x264Optimization::dispatch($this->video, $this->video->type);
        }
//        \Storage::disk('videos')->delete($old_originalpath);


//        $ff = \FFMpeg::fromDisk('videos')->open($old_originalpath);
//        $ff->filters()->clip(TimeCode::fromSeconds((float) $this->start), TimeCode::fromSeconds((float) $this->end));
//        $ff->export()->toDisk('videos')->inFormat(new \FFMpeg\Format\Video\X264())->save($this->video->tag.'/'.$new_originalhash.'.mp4');
//
//        $this->video->original = $new_originalhash.'.mp4';
//        $this->video->save();
//        if($this->video->type != VideoType::Original()){
//            $files = \Storage::disk('videos')->files($this->video->tag.'/stream');
//            $matchingFiles = preg_grep('/.*?'.mb_substr($this->video->streamhash, 0, -5).'?/', $files);
//            foreach($matchingFiles as $file){
//                \Storage::disk('videos')->delete($file);
//            }
//            x264Optimization::dispatch($this->video, $this->video->type);
//        }
//        \Storage::disk('videos')->delete($old_originalpath);
    }
}
