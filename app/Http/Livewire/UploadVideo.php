<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadVideo extends Component
{
    use WithFileUploads;

    public $video, $title;

    public function upload()
    {

        $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
//            'type' => 'required'
        ]);

        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName();

        Video::create([
            'title' => $title,
            'original' => $hash,
        ]);
    }
//    public function render()
//    {
//        return view('livewire.upload-video');
//    }
}
