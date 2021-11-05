<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSolutionsNullablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('selected')->default(0)->change();
            $table->integer('rejected')->default(0)->change();
            $table->boolean('archive')->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('selected')->nullable()->change();
            $table->integer('rejected')->nullable()->change();
            $table->boolean('archive')->nullable()->change();
        });
    }
}
