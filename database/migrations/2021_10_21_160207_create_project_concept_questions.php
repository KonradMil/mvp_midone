<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectConceptQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_concept_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_concept_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('project_concept_id')->references('id')->on('project_concepts');
            $table->foreign('question_id')->references('id')->on('questions');
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
        Schema::dropIfExists('project_content_questions');
    }
}
