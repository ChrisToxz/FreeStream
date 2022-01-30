<?php

namespace App\Http\Livewire;

use App\Enums\RetentionType;
use App\Models\Video;
use Livewire\Component;

class EditVideo extends Component
{

    public Video $video;
    public $title, $retention, $retention_type, $retention_value, $type;

    protected $rules = [

        'video.title' => 'required|string',
        'retention' => 'string'

    ];

    public function mount(Video $video)
    {
        $this->video = $video;
        $this->retention = $video->retention()->exists() ? 1 : 0;
        if($this->retention){
            $this->retention_type = $video->retention->type;
            $this->retention_value = $video->retention->value;
        }
    }

    public function update(Video $video)
    {

        // TODO: firstOrCreate not working
        \Log::info('Update retention');
        if($this->retention){

            \Log::info('Has retention');
            if($video->retention){
                \Log::info('exists retention');
                $this->video->retention()->update(['value' => $this->retention_value, 'type' => $this->retention_type ?? RetentionType::Views()]);
            }else{
                \Log::info('no retention');
                $this->video->retention()->create(['value' => $this->retention_value, 'type' => $this->retention_type ?? RetentionType::Views()]);
            }

        }
        $video->save();
        $this->emit('refreshVideos');
    }


    public function render()
    {
        return view('livewire.edit-video')->with(['info' => json_encode($this->video->info)]);
    }
}
