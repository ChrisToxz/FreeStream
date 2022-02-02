<?php

namespace App\Http\Livewire;

use App\SlipstreamSettings;
use Livewire\Component;

class Settings extends Component
{

    public $settings;

    public function update(SlipstreamSettings $settings)
    {
        foreach($this->settings as $k=>$setting){
            $settings->$k = $setting;
        }
        $settings->save();
        toastr()->livewire()->addSuccess('Settings saved!');
    }


    public function mount(SlipstreamSettings $settings){
        $this->settings = $settings->toCollection();
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
