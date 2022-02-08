<?php

namespace App\Http\Livewire;

use App\Enums\VideoType;
use App\Jobs\x264Optimization;
use App\Models\Video;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Str;
use Livewire\Component;

class TrimVideo extends Component
{
    public $video;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function trim(){
        $new_originalhash = Str::random(40);
        $old_originalpath = $this->video->editableVideoPath;

        $ff = \FFMpeg::fromDisk('videos')->open($old_originalpath);
        $ff->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(5));
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

    public function render()
    {
        return view('livewire.trim-video');
    }
}
