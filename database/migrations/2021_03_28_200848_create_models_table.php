<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category');
            $table->integer('subcategory');
            $table->float('price')->nullable();
            $table->string('model_file');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('max_load_kg')->nullable();
            $table->string('max_range_mm')->nullable();
            $table->string('axis')->nullable();
            $table->string('max_speed_mms')->nullable();
            $table->string('tech_sheet')->nullable();
            $table->string('connection_method')->nullable();
            $table->string('range')->nullable();
            $table->string('repetity')->nullable();
            $table->string('load')->nullable();
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
        Schema::dropIfExists('models');
    }
}
