<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class LoadVideos extends Component
{
    public $perPage = 8000;
    protected $listeners = [
        'load-more' => 'loadMore',
        'videosRefresh' => '$refresh',

    ];

    public function loadMore()
    {
        $this->perPage = $this->perPage + 800;
    }

    public function render()
    {

//        $videos = Video::latest()->paginate($this->perPage);
        $videos = Video::latest()->get();
        return view('livewire.load-videos', ['videos' => $videos]);
    }
}
