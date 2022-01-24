// resources/lang/en/enums.php
<?php

use App\Enums\VideoType;

return [

    VideoType::class => [
        VideoType::Original => 'Original file',
        VideoType::X264 => 'Web optimzation (x264)',
        VideoType::Streamable => 'Streamable (x264/HLS)'
    ],

];
