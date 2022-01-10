<?php

namespace App\Http\Livewire;

use App\Events\videoUploaded;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\ConvertVideo;
use App\Models\Video;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class UploadVideo extends Component
{
    use WithFileUploads;

    public $video, $title, $type;

    public function save()
    {
        $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
            'type' => 'required'
        ]);

        toastr()->livewire()->title('Preparing!')->addInfo('Preparing video!');
        $tag = Str::random(4); // generate tag
        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName(); // generator hash

        // Create Thumb
        $media = FFMpeg::openUrl($this->video->path());
        $media->getFrameFromSeconds(0.1)->export()->toDisk('videos')->save($tag.'/thumb.jpg');

        $this->video->storeAs($tag, $hash, 'videos'); // store original video

        $video = Video::create(array(
            'tag' => $tag,
            'hash' => $hash,
            'title' => $title,
            'type'  => $this->type,
        ));

        videoUploaded::dispatch($video);


        toastr()->livewire()->title('Success!')->addSuccess('Video uploaded!');
        $this->emit('videosRefresh');

        switch ($this->type){
            case 0://original
                $video->files = ['mp4' => $hash];
                $video->save();
                break;
            case 1: //x264
                ConvertVideo::dispatch($video);
                break;
            case 2://streamable
                ConvertVideoForStreaming::dispatch($video);
                break;

        }
    }

//    public function render()
//    {
//        return view('livewire.upload-video');
//    }
}
