<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class deleteTempLivewire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slipstream:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temp folder of uploaded files';

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
        Storage::deleteDirectory('livewire-tmp');
    }
}