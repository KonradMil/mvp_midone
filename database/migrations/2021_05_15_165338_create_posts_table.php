<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('wp_id')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->integer('type_investor', false)->nullable();
            $table->integer('type_installer', false)->nullable();
            $table->text('excerpt')->nullable();
            $table->text('thumbnail')->nullable();
            $table->mediumText('content')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
