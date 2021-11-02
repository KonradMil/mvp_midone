<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinancialAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->double('cost_per_hour_before')->nullable();
            $table->double('cost_per_hour_after')->nullable();
            $table->double('cost_per_year_before')->nullable();
            $table->double('cost_per_year_after')->nullable();
            $table->double('cost_per_piece_before')->nullable();
            $table->double('cost_per_piece_after')->nullable();
            $table->double('monthly_reduction_before')->nullable();
            $table->double('monthly_reduction_after')->nullable();
            $table->double('monthly_savings_before')->nullable();
            $table->double('monthly_savings_after')->nullable();
            $table->double('tkw_reduction_before')->nullable();
            $table->double('tkw_reduction_after')->nullable();
            $table->double('additional_savings_before')->nullable();
            $table->double('additional_savings_after')->nullable();
            $table->double('capex')->nullable();
            $table->double('cost_capital')->nullable();
            $table->double('timeframe')->nullable();
            $table->double('monthly_savings')->nullable();
            $table->double('simple_payback')->nullable();
            $table->double('npv')->nullable();
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
        Schema::dropIfExists('financial_analyses');
    }
}
