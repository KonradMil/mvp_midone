<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLocalVisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('local_visions', function (Blueprint $table) {
            $table->renameColumn('challenge_id', 'project_id');
        });
        Schema::table('local_visions', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->change();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->integer('accepted')->default(0);
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('local_visions', function (Blueprint $table){
            $table->dropForeign('local_visions_project_id_foreign');
            $table->dropForeign('local_visions_author_id_foreign');
        });
        Schema::table('local_visions', function (Blueprint $table){
            $table->renameColumn('project_id','challenge_id');
        });
        Schema::table('local_visions', function (Blueprint $table) {
            $table->integer('project_id')->change();
            $table->dropColumn('author_id');
            $table->dropColumn('accepted');
            $table->dropColumn('comment');
        });
    }
}
