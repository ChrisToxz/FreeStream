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
            $table->id();
            $table->string('tag')->unique();

            $table->string('title');

            $table->string('file');
            $table->string('streamfile')->nullable();

            $table->integer('duration')->nullable();
            $table->json('video')->nullable();

            $table->integer('size')->nullable();
            $table->integer('streamsize')->nullable();

            $table->integer('job_id')->nullable();
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
