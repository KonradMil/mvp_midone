<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->integer('days')->default(260);
            $table->integer('shifts')->default(30);
            $table->integer('shift_time')->default(8);
            $table->integer('weekend_shift')->default(0);
            $table->integer('breakfast')->default(30);
            $table->integer('stop_time')->default(20);
            $table->integer('operator_performance')->default(90);
            $table->integer('defective')->default(5);
            $table->integer('number_of_operators')->default(2);
            $table->integer('operator_cost')->default(4500);
            $table->integer('absence')->default(12);
            $table->integer('challenge_id');
            $table->integer('cycle_time')->nullable();
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
        Schema::dropIfExists('financials');
    }
}
