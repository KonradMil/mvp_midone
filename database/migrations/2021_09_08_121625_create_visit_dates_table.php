<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->integer('project_id');
            $table->timestamp('deadline');
            $table->tinyInteger('accepted_investor');
            $table->tinyInteger('accepted_integrator');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('visit_dates');
    }
}
