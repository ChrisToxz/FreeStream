<?php

namespace App\Console\Commands;

use App\Enums\RetentionType;
use App\Jobs\deleteVideo;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkRetention extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slipstream:checkretention';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Slipstream - Check if retention rule needs to be executed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $videos = Video::with('retention')->whereHas('retention', function($q){
            $q->where('value', '<=', Carbon::now()->toDateTimeLocalString())
            ->where('type', '=', RetentionType::Datetime());
        });
        print($videos->count().' videos will be deleted');
        foreach($videos->get() as $video){
            deleteVideo::dispatch($video);
        }
    }
}
