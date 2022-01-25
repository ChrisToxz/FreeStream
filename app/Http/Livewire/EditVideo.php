<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class EditVideo extends Component
{

    public Video $video;
    public $title;

    protected $rules = [

        'video.title' => 'required|string',

    ];

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function update()
    {
        $this->video->save();
        $this->emit('refreshVideos');
    }


    public function render()
    {
        return view('livewire.edit-video');
    }
}
