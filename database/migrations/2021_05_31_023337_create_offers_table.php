<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->float('price')->default(0);
            $table->integer('guarantee_period')->default(1);
            $table->integer('guarantee_scope')->default(1);
            $table->timestamp('start_date')->nullable();
            $table->float('start_weeks')->default(1);
            $table->float('advance_after_contract')->default(0);
            $table->float('advance_during_installation')->default(0);
            $table->float('advance_after_start')->default(0);

            $table->integer('service_contract')->default(1);
            $table->float('service_price')->default(0);
            $table->integer('service_support_scope')->default(1);
            $table->integer('response_time')->default(1);

            $table->integer('status', false);
            $table->integer('challenge_id');
            $table->integer('solution_id');
            $table->integer('installer_id');
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
        Schema::dropIfExists('offers');
    }
}
