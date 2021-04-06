<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('solution_deadline');
            $table->timestamp('offer_deadline');
            $table->integer('status');
            $table->integer('published');
            $table->longText('save_json');
            $table->string('screenshot_path')->nullable();
            $table->integer('author_id');
            $table->integer('financial_before_id');
            $table->integer('client_id');
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
        Schema::dropIfExists('challenges');
    }
}
