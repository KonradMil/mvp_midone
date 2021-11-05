<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_risks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('project_id');
            $table->text('risk_description')->nullable();
            $table->text('risk_area')->nullable();
            $table->unsignedInteger('event_probability')->nullable();
            $table->unsignedInteger('cost_impact')->nullable();
            $table->unsignedInteger('schedule_impact')->nullable();
            $table->unsignedInteger('quality_implementation_impact')->nullable();
            $table->text('risk_limitations')->nullable();
            $table->text('comment_integrator')->nullable();
            $table->text('comment_investor')->nullable();
            $table->unsignedInteger('is_accepted')->default(0);
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
        Schema::dropIfExists('project_risks');
    }
}
