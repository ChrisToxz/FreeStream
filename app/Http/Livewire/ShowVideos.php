<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideos extends Component
{
    public function render()
    {
        $videos = Video::all();
        return view('livewire.show-videos')->with(['videos' => $videos]);
    }
}
