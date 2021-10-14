<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table){
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('is_offer_project')->default(0);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table){
            $table->dropForeign('offers_project_id_foreign');
        });
        Schema::table('offers', function (Blueprint $table){
            $table->dropColumn('comment');
            $table->dropColumn('is_offer_project');
            $table->dropColumn('project_id');
        });
    }
}
