<?php

namespace App\Http\Livewire;

use App\Models\Video;
use FFMpeg\Coordinate\TimeCode;
use Livewire\Component;

class TrimVideo extends Component
{
    public $video;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function trim(){
        $ff = \FFMpeg::fromDisk('videos')->open($this->video->originalpath);
        $ff->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(5));
        $ff->export()->toDisk('videos')->inFormat(new \FFMpeg\Format\Video\X264())->save('trimmed'.qu$this->video->originalpath);

    }

    public function render()
    {
        return view('livewire.trim-video');
    }
}
