<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('contest_id')->nullable();
            $table->foreign('contest_id')->references('id')->on('contests');
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
        Schema::dropIfExists('contest_tasks');
    }
}
