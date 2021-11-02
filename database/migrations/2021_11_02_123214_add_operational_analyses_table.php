<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOperationalAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->double('time_available_before')->nullable();
            $table->double('time_available_after')->nullable();
            $table->double('time_available_change')->nullable();
            $table->double('time_production_before')->nullable();
            $table->double('time_production_after')->nullable();
            $table->double('time_production_change')->nullable();
            $table->double('production_before')->nullable();
            $table->double('production_after')->nullable();
            $table->double('production_change')->nullable();
            $table->double('good_arts_production_before')->nullable();
            $table->double('good_arts_production_after')->nullable();
            $table->double('good_arts_production_change')->nullable();
            $table->double('availability_factor_before')->nullable();
            $table->double('availability_factor_after')->nullable();
            $table->double('availability_factor_change')->nullable();
            $table->double('productivity_coefficient_before')->nullable();
            $table->double('productivity_coefficient_after')->nullable();
            $table->double('productivity_coefficient_change')->nullable();
            $table->double('quality_factor_before')->nullable();
            $table->double('quality_factor_after')->nullable();
            $table->double('quality_factor_change')->nullable();
            $table->double('oee_before')->nullable();
            $table->double('oee_after')->nullable();
            $table->double('oee_change')->nullable();
            $table->double('production_volume_before')->nullable();
            $table->double('production_volume_after')->nullable();
            $table->double('production_volume_change')->nullable();
            $table->double('pph_per_person_before')->nullable();
            $table->double('pph_per_person_after')->nullable();
            $table->double('pph_per_person_change')->nullable();
            $table->foreign('solution_id')->references('id')->on('solutions');
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
        Schema::dropIfExists('operational_analyses');
    }
}
