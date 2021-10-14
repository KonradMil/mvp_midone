<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_saves', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('en_name');
            $table->longText('description');
            $table->longText('en_description');
            $table->longText('save_json');
            $table->string('screenshot_path');
            $table->timestamps();
        });

        Schema::create('free_saves_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('free_save_id');
            $table->tinyInteger('is_owner');
            $table->timestamps();
        });

        Schema::table('free_saves_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('free_save_id')->references('id')->on('free_saves');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_saves_users', function (Blueprint $table) {
            $table->dropForeign('free_saves_users_user_id_foreign');
            $table->dropForeign('free_saves_users_free_save_id_foreign');
        });
        Schema::dropIfExists('free_saves_user');
        Schema::dropIfExists('free_saves');
    }
}
