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
//            $table->id();
            $table->string('tag')->primary();
            $table->string('title');
            $table->string('hash');
            $table->string('streamhash')->nullable();
//            $table->json('files');
            $table->enum('type', \App\Enums\VideoType::getValues())
                ->default(\App\Enums\VideoType::Original);
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
