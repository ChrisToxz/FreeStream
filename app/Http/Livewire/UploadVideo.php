<?php

namespace App\Http\Livewire;

use App\Enums\RetentionType;
use App\Enums\VideoType;
use App\Jobs\x264Optimization;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class UploadVideo extends Component
{
    use WithFileUploads;

    public $video, $title, $type, $retention, $retention_type, $retention_value, $password, $password_value;

    public function upload()
    {
        $vali = $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
        ]);
        // filesize dd($this->video);

        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName();

        $type = $this->type ?? VideoType::Original()->value;


        $media = FFMpeg::openUrl($this->video->path());

        $video = Video::create([
            'title'     => $title,
            'original'  => $hash,
            'type'      => $type,
            'info'      => [
                'duration'=>$media->getDurationInSeconds(),
                'size' => round($this->video->getSize()/1000000), // to MB
                'extension' => $this->video->extension(),
                'codec_name' => $media->getVideoStream()->get('codec_name'),
                'codec_long_name' => $media->getVideoStream()->get('codec_long_name'),
                'bit_rate' => $media->getVideoStream()->get('bit_rate'),
                'width' => $media->getVideoStream()->get('width'),
                'height' => $media->getVideoStream()->get('height'),
                'r_frame_rate' => $media->getVideoStream()->get('r_frame_rate'),
                'avg_frame_rate' => $media->getVideoStream()->get('avg_frame_rate'),
                'tags' => $media->getVideoStream()->get('tags'),
            ],
            'password' => (!is_null($this->password_value)) ? Hash::make($this->password_value) : null,
        ]);

        // Create Thumb
        $media->getFrameFromSeconds(0.1)->export()->toDisk('videos')->save($video->tag.'/thumb.jpg');

        $this->video->storeAs($video->tag, $hash, 'videos');

        if($type == VideoType::Original){
            $this->video->streamhash = $hash;
        }else{
            x264Optimization::dispatch($video, $type);
        }

        if($this->retention){
            if(!$this->retention_type || !$this->retention_value){
                dd('No values');
            }
            $video->retention()->create(['type'=>$this->retention_type, 'value'=>$this->retention_value]);
        }



        toastr()->livewire()->addSuccess('Video uploaded! Tag: '.$video->tag);
        $this->dispatchBrowserEvent('resetform');
        $this->emit('refreshVideos');
    }

//    public function render()
//    {
//        return view('livewire.upload-video');
//    }
}
