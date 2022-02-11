<?php

namespace App\Jobs;

use App\Enums\VideoType;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Imtigger\LaravelJobStatus\Trackable;

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
//        $this->prepareStatus(['video_id' => $video->id]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $new_originalhash = Str::random(40);
        $old_originalpath = $this->video->editableVideoPath;

        $ff = \FFMpeg::fromDisk('videos')->open($old_originalpath);
        $ff->filters()->clip(TimeCode::fromSeconds((float) $this->start), TimeCode::fromSeconds((float) $this->end));
        $ff->export()->toDisk('videos')->inFormat(new \FFMpeg\Format\Video\X264())->save($this->video->tag.'/'.$new_originalhash.'.mp4');

        $this->video->original = $new_originalhash.'.mp4';
        $this->video->save();
        if($this->video->type != VideoType::Original()){
            $files = \Storage::disk('videos')->files($this->video->tag.'/stream');
            $matchingFiles = preg_grep('/.*?'.mb_substr($this->video->streamhash, 0, -5).'?/', $files);
            foreach($matchingFiles as $file){
                \Storage::disk('videos')->delete($file);
            }
            x264Optimization::dispatch($this->video, $this->video->type);
        }
        \Storage::disk('videos')->delete($old_originalpath);
    }
}
