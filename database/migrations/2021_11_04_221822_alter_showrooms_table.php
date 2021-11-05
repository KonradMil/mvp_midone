<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterShowroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('showrooms', function(Blueprint $table){
            $table->mediumText('description')->nullable();
            $table->string('organization')->nullable();
            $table->string('organization_logo')->nullable();
            $table->string('dominant_color')->nullable();
            $table->mediumText('custom_functions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
