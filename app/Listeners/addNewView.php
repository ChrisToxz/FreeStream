<?php

namespace App\Listeners;

use App\Events\videoView;
use App\Models\View;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class addNewView
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\videoView  $event
     * @return void
     */
    public function handle(videoView $event)
    {

        $view = new View();
        $view->video_id = $event->video->id;
        $view->save();
    }
}
