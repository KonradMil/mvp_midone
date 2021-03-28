<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
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
            $table->timestamp('solution_deadline');
            $table->timestamp('offer_deadline');
            $table->integer('status');
            $table->integer('published');
            $table->longText('save_json');
            $table->string('screenshot_path')->nullable();
            $table->integer('author_id');
            $table->integer('financial_before_id');
            $table->integer('client_id');
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
        Schema::dropIfExists('challenges');
    }
}
