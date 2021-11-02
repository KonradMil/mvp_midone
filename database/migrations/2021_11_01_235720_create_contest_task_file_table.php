<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestTaskFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_task_files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('extension')->nullable();
            $table->string('path');
            $table->unsignedBigInteger('contest_task_id')->nullable();
            $table->foreign('contest_task_id')->references('id')->on('contest_tasks');
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
        Schema::dropIfExists('contest_task_files');
    }
}
