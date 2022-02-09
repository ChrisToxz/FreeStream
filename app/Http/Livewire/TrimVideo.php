<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class TrimVideo extends Component
{
    public $video, $start, $end;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function trim(){

        $this->validate([
            'start' => 'required|integer',
            'end' => 'required|integer'
        ]);

        \App\Jobs\TrimVideo::dispatch($this->video, $this->start, $this->end);
        $this->emit('refreshVideos');
    }

    public function render()
    {
        return view('livewire.trim-video');
    }
}
