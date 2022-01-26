<?php

namespace App;

use Spatie\LaravelSettings\Settings;

class SlipstreamSettings extends Settings
{
    public string $site_name;

    public bool $keep_original_file;

    public bool $guests_can_see_video_info;

    public int $view_retention_delay;

    public array $streaming_bitrates;

    public static function group(): string
    {
        return 'general';
    }
}
