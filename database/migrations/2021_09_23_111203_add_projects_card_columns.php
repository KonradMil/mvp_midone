<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectsCardColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
              $table->dropColumn('screenshot_path');
              $table->dropColumn('save_json');
              $table->dropColumn('solution_deadline');
              $table->dropColumn('offer_deadline');
              $table->unsignedTinyInteger('accept_offer')->default(0);
              $table->unsignedTinyInteger('accept_technical_details')->default(0);
              $table->unsignedTinyInteger('accept_financial_details')->default(0);
              $table->unsignedTinyInteger('accept_local_vision')->default(0);
              $table->unsignedTinyInteger('accept_visit_date')->default(0);
              $table->unsignedTinyInteger('selected_offer_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('screenshot_path')->nullable();
            $table->longText('save_json')->nullable();
            $table->timestamp('solution_deadline');
            $table->timestamp('offer_deadline');
            $table->dropColumn('accept_offer');
            $table->dropColumn('accept_technical_details');
            $table->dropColumn('accept_financial_details');
            $table->dropColumn('accept_local_vision');
            $table->dropColumn('accept_visit_date');
            $table->dropColumn('selected_offer_id');
        });
    }
}
