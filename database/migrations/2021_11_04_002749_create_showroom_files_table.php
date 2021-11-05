<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowroomFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showroom_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ext')->nullable();
            $table->string('original_name')->nullable();
            $table->string('path');
            $table->float('size')->nullable();
            $table->string('alt')->nullable();
            $table->unsignedBigInteger('showroom_id')->nullable();
            $table->foreign('showroom_id')->references('id')->on('showrooms');
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
        Schema::dropIfExists('showroom_files');
    }
}
