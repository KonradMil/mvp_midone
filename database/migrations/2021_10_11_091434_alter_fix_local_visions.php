<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFixLocalVisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('local_visions', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('before')->nullable()->change();
            $table->text('after')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('local_visions', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->string('before')->nullable()->change();
            $table->string('after')->nullable()->change();
        });
    }
}
