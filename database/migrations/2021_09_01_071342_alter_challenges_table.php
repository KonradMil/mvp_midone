<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenges', function (Blueprint $table) {

            $table->integer('project_accept_offer')->default(0);
            $table->integer('project_accept_details')->default(0);
            $table->integer('project_accept_vision')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenges', function (Blueprint $table) {

            $table->removeColumn('project_accept_offer');
            $table->removeColumn('project_accept_details');
            $table->removeColumn('project_accept_vision');

        });
    }
}
