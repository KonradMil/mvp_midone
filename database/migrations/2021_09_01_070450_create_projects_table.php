<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('name')->nullable();
            $table->integer('challenge_id')->nullable();
            $table->string('en_name')->nullable();
            $table->string('description')->nullable();
            $table->string('en_description')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->longText('save_json')->nullable();
            $table->integer('status')->default(0);
            $table->integer('stage')->nullable();
            $table->timestamp('solution_deadline');
            $table->timestamp('offer_deadline');
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
        Schema::dropIfExists('projects');
    }
}
