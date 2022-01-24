<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideos extends Component
{
    protected $listeners = ['refreshVideos' => '$refresh'];

    public function render()
    {
        $videos = Video::latest()->get();
        return view('livewire.show-videos')->with(['videos' => $videos]);
    }
}
