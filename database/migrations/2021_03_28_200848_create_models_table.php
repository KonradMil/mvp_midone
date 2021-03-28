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
            $table->float('price');
            $table->string('model_file');
            $table->string('brand');
            $table->string('model');
            $table->string('max_load_kg');
            $table->string('max_range_mm');
            $table->string('axis');
            $table->string('max_speed_mms');
            $table->string('tech_sheet');
            $table->string('connection_method');
            $table->string('range');
            $table->string('repetit');
            $table->string('load');
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
