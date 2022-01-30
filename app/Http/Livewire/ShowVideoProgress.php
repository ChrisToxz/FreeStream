<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideoProgress extends Component
{
    public $video;


    public function render()
    {
        if($this->video->job->is_finished){
            // Refresh videos when finished to show buttons
            $this->emit('refreshVideos');
        }
        return view('livewire.show-video-progress');
    }
}
