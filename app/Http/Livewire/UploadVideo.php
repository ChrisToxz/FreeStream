<?php

namespace App\Http\Livewire;

use App\Enums\VideoType;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class UploadVideo extends Component
{
    use WithFileUploads;

    public $video, $title, $type, $retention, $retention_type, $retention_value;

    public function upload()
    {
        $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska'
        ]);

        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName();

        $type = $this->type ?? VideoType::Original();

        $video = Video::create([
            'title'     => $title,
            'original'  => $hash,
            'type'      => $type,
        ]);

        // Create Thumb
        $media = FFMpeg::openUrl($this->video->path());
        $media->getFrameFromSeconds(0.1)->export()->toDisk('videos')->save($video->tag.'/thumb.jpg');

        $this->video->storeAs($video->tag, $hash, 'videos');
    }

//    public function render()
//    {
//        return view('livewire.upload-video');
//    }
}
