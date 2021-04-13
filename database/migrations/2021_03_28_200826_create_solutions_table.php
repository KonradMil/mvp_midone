<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('en_name');
            $table->string('screenshot_path');
            $table->mediumText('description')->nullable();
            $table->mediumText('en_description')->nullable();
            $table->float('price')->nullable();
            $table->integer('author_id');
            $table->integer('challenge_id');
            $table->integer('installer_id')->nullable();
            $table->integer('financial_after_id')->nullable();
            $table->integer('status');
            $table->integer('published');
            $table->longText('save_json')->nullable();
            $table->timestamp('deadline_offered')->nullable();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('solutions');
    }
}
