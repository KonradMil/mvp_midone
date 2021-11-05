<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectConceptFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_concept_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_concept_id');
            $table->unsignedBigInteger('file_id');
            $table->foreign('project_concept_id')->references('id')->on('project_concepts');
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::dropIfExists('project_concept_files');
    }
}
