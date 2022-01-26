<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateSlipstreamSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Slipstream');
        $this->migrator->add('general.keep_original_file', false);
        $this->migrator->add('general.guests_can_see_video_info', true);
        $this->migrator->add('general.view_retention_delay', 5);
        $this->migrator->add('general.streaming_bitrates', [360=>100,720=>500,1080=>1000,1440=>1500,2160=>2160]);
    }
}
