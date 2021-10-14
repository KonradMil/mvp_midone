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

            $table->string('en_name', 255)->nullable()->after('name');
            $table->longText('en_description')->nullable()->after('description');
            $table->integer('status')->default(0)->change();
            $table->integer('stage')->default(0)->change();
            $table->unsignedBigInteger('financial_before_id')->change();
            $table->unsignedBigInteger('author_id')->change();
            $table->unsignedBigInteger('solution_project_id')->nullable();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('financial_before_id')->references('id')->on('financials');
            $table->foreign('technical_details_id')->references('id')->on('technical_details');
            $table->foreign('selected_offer_id')->references('id')->on('offers');
            $table->foreign('solution_project_id')->references('id')->on('solutions');
            $table
                ->foreign('love_reactant_id')
                ->references('id')
                ->on('love_reactants');

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
