<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadVideo extends Component
{
    use WithFileUploads;

    public $video, $title, $type, $retention, $retention_type, $retention_value;

    public function upload()
    {
        dd($this);
        $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
            'type' => 'required'
        ]);

        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName();

        Video::create([
            'title'     => $title,
            'original'  => $hash,
            'type'      => $this->type,
        ]);
    }

//    public function render()
//    {
//        return view('livewire.upload-video');
//    }
}
