<?php

namespace App\Http\Livewire;

use App\Jobs\deleteVideo;
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

    public function delete(Video $video){
        // TODO: Use job function including emit for refresh
        \Storage::disk('videos')->deleteDirectory($video->tag);
        $video->deleteOrFail();
        $this->emit('refreshVideos');
        toastr()->livewire()->addSuccess('Video deleted!');
    }
}
