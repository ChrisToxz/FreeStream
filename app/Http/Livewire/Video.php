<?php

namespace App\Http\Livewire;

use App\Events\videoUploaded;
use App\Jobs\ConvertVideo;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class Video extends Component
{
    use WithFileUploads;

    public $video, $title, $type;

    public function render()
    {
        return view('livewire.video');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
            'type' => 'required'
        ]);

        $tag = Str::random(4); // generate tag
        $title = $this->title ?? $this->video->getClientOriginalName();
        $hash = $this->video->hashName(); // generator hash

        // Create Thumb
        $media = FFMpeg::openUrl($this->video->path());
        $media->getFrameFromSeconds(0.1)->export()->toDisk('videos')->save($tag.'/thumb.jpg');

        $this->video->storeAs($tag, $hash, 'videos'); // store original video

        $video = \App\Models\Video::create(array(
            'tag' => $tag,
            'hash' => $hash,
            'title' => $title,
            'type'  => $this->type,
        ));

        videoUploaded::dispatch($video);

        $this->dispatchBrowserEvent('resetform');
        $this->emit('videosRefresh');

        switch ($this->type){
            case 0://original
                $video->files = ['mp4' => $hash];
                $video->save();
                toastr()->livewire()->title('Success!')->addSuccess('Video uploaded!');
                break;
            case 1: //x264
                ConvertVideo::dispatch($video);
                toastr()->livewire()->title('Success!')->addSuccess('Video uploaded, being processed now!');
                break;
            case 2://streamable
                ConvertVideoForStreaming::dispatch($video);
                toastr()->livewire()->title('Success!')->addSuccess('Video uploaded, being processed now!');
                break;

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Video $video)
    {

        switch ($video->type){
            case 0:
                return View::make('view')->with(['video' => $video]);
                break;
            case 1:
                return View::make('view')->with(['video' => $video]);
                break;
            case 2:
                return View::make('view2')->with(['video' => $video]);
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
    }
}
