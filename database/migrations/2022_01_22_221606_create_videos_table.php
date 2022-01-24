<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('tag')->primary();
            $table->string('title');
            $table->string('original'); // original video hash filename
            $table->string('streamhash')->nullable(); // filename/path of mp4/m3u8
            $table->enum('type', \App\Enums\VideoType::getValues())->default(\App\Enums\VideoType::Original());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
