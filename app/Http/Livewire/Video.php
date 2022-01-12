<?php

namespace App\Http\Livewire;

use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Video extends Component
{
    public $perPage = 8000;
    protected $listeners = [
        'load-more' => 'loadMore',
        'videosRefresh' => '$refresh',
    ];

    public $video, $title, $type;

    public function render()
    {
        $videos = \App\Models\Video::latest()->get();
        return view('livewire.load-videos', ['videos' => $videos]);
    }

    public function edit(\App\Models\Video $video)
    {

        $this->title = $video->title;
    }

    public function update()
    {
        dd($this->title);
    }

    public function destroy(\App\Models\Video $video)
    {
        Storage::disk('videos')->deleteDirectory($video->tag);
        $video->delete();
        toastr()->livewire()->title('Success!')->addSuccess('Video deleted!');
//        $this->emit('videosRefresh');
    }
}
