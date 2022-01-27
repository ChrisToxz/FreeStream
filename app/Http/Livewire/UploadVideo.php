<?php

namespace App\Http\Livewire;

use App\Enums\RetentionType;
use App\Enums\VideoType;
use App\Jobs\x264Optimization;
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
        $vali = $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
        ]);

        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName();

        $type = $this->type ?? VideoType::Original()->value;

        $video = Video::create([
            'title'     => $title,
            'original'  => $hash,
            'type'      => $type,
        ]);

        // Create Thumb
        $media = FFMpeg::openUrl($this->video->path());
        $media->getFrameFromSeconds(0.1)->export()->toDisk('videos')->save($video->tag.'/thumb.jpg');

        $this->video->storeAs($video->tag, $hash, 'videos');

        switch($type){
            case 1: // original
                // File already stored, just save stream hash.
                $this->video->streamhash = $hash;
                break;
            case 2: // x264
                x264Optimization::dispatch($video);
                break;
            case 3: // x264 + HLS
                break;
        }

        if($this->retention){
            if(!$this->retention_type || !$this->retention_value){
                dd('No values');
            }
            $video->retention()->create(['type'=>$this->retention_type, 'value'=>$this->retention_value]);
        }

        smilify('success', 'Video uploaded!');
        $this->emit('refreshVideos');
    }

//    public function render()
//    {
//        return view('livewire.upload-video');
//    }
}
