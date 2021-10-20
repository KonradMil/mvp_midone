<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_communications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('project_id');
            $table->string('personal_occupation');
            $table->string('personal_data');
            $table->unsignedInteger('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('project_decision')->default(0);
            $table->unsignedTinyInteger('is_accepted')->default(0);
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('project_communications');
    }
}
