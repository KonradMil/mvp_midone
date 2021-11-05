<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowroomVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showroom_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('email');
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
        Schema::dropIfExists('showroom_visitors');
    }
}
