<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_details', function (Blueprint $table) {
            $table->id();
            $table->integer('challenge_id')->nullable();
            $table->integer('solution_id')->nullable();
            $table->integer('detail_weight')->nullable();
            $table->integer('pick_quality');
            $table->integer('detail_material');
            $table->integer('detail_size');
            $table->integer('detail_pick');
            $table->integer('detail_position');
            $table->integer('detail_range');
            $table->integer('detail_destination');
            $table->integer('number_of_lines');
            $table->integer('cycle_time');
            $table->integer('work_shifts');
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
        Schema::dropIfExists('technical_details');
    }
}
