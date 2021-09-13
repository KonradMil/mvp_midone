<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Cog\Laravel\Love\Reactant\Models\Reactant;
use Cog\Laravel\Love\Reactant\ReactionCounter\Models\ReactionCounter;
use Cog\Laravel\Love\Reactant\ReactionTotal\Models\ReactionTotal;
use Cog\Laravel\Love\Reacter\Models\Reacter;
use Cog\Laravel\Love\Reaction\Models\Reaction;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;

class CoreTablesFixer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('challenge_files', function (Blueprint $table) {
            $table->unsignedBigInteger('challenge_id')->change();
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('file_id')->change();
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('file_id')->references('id')->on('files');
        });

        Schema::table('challenge_image', function (Blueprint $table) {
            $table->unsignedBigInteger('challenge_id')->change();
            $table->unsignedBigInteger('image_id')->change();
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('image_id')->references('id')->on('files');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->change();
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('estimates', function (Blueprint $table) {
            $table->json('parts_ar')->after('sum');
            $table->unsignedBigInteger('solution_id')->change();
            $table->foreign('solution_id')->references('id')->on('solutions');
        });

        Schema::table('knowledgebase_videos', function (Blueprint $table) {

            $table->string('en_name')->nullable()->after('name');
            $table->string('en_description')->nullable()->after('description');
            $table->foreign('love_reactant_id')->references('id')->on('love_reactants');

        });

        Schema::table((new ReactionCounter())->getTable(), function (Blueprint $table) {

            $table->foreign('reactant_id')
                ->references('id')
                ->on('love_reactants')
                ->onDelete('cascade');

            $table
                ->foreign('reaction_type_id')
                ->references('id')
                ->on('love_reaction_types')
                ->onDelete('cascade');

        });

        Schema::table((new ReactionTotal())->getTable(), function (Blueprint $table) {

            $table
                ->foreign('reactant_id')
                ->references('id')
                ->on('love_reactants')
                ->onDelete('cascade');

        });

        Schema::table((new Reaction)->getTable(), function (Blueprint $table) {

            $table
                ->foreign('reactant_id')
                ->references('id')
                ->on((new Reactant())->getTable())
                ->onDelete('cascade');
            $table
                ->foreign('reacter_id')
                ->references('id')
                ->on((new Reacter())->getTable())
                ->onDelete('cascade');
            $table
                ->foreign('reaction_type_id')
                ->references('id')
                ->on((new ReactionType())->getTable())
                ->onDelete('cascade');

        });

        Schema::table('offers', function (Blueprint $table) {
            $table->float('price_of_delivery')->nullable()->default(1)->change();
            $table->boolean('selected')->default(false)->change();
            $table->boolean('rejected')->default(false)->change();

            $table->unsignedBigInteger('challenge_id')->change();
            $table->unsignedBigInteger('solution_id')->change();
            $table->unsignedBigInteger('installer_id')->change();
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->foreign('installer_id')->references('id')->on('users');
        });

        Schema::table('questions', function (Blueprint $table) {

            $table->unsignedBigInteger('author_id')->nullable(false)->change();
            $table->unsignedBigInteger('challenge_id')->change();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('challenge_id')->references('id')->on('challenges');

        });

        Schema::table('ratings', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('solutions', function (Blueprint $table) {

            $table->unsignedBigInteger('author_id')->change();
            $table->unsignedBigInteger('challenge_id')->change();
            $table->unsignedBigInteger('installer_id')->change();
            $table->unsignedBigInteger('financial_after_id')->change();
            $table->string('en_name')->default('Solution')->after('name');
            $table->mediumText('en_description')->nullable()->after('description');

            $table
                ->foreign('love_reactant_id')
                ->references('id')
                ->on('love_reactants');

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('installer_id')->references('id')->on('users');
            $table->foreign('financial_after_id')->references('id')->on('financials');

        });

        Schema::table('taggables', function (Blueprint $table) {

            $table->foreign('tag_id')->references('id')->on('tags');

        });

        Schema::table('team_challenge', function (Blueprint $table) {

            $table->unsignedBigInteger('challenge_id')->change();
            $table->unsignedInteger('team_id')->change();

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('team_id')->references('id')->on('teams');

        });

        Schema::table('team_invites', function (Blueprint $table) {

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

        });

        Schema::table('team_solution', function (Blueprint $table) {

            $table->unsignedBigInteger('solution_id')->change();
            $table->unsignedInteger('team_id')->change();

            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->foreign('team_id')->references('id')->on('teams');

        });

        Schema::table('team_user', function (Blueprint $table) {

            $table->boolean('owner');
            $table->boolean('publishChallenge')->nullable();
            $table->boolean('editChallenge')->nullable();
            $table->boolean('acceptChallengeSolution')->nullable();
            $table->boolean('acceptChallengeOffer')->nullable();
            $table->boolean('publishSolution')->nullable();
            $table->boolean('addSolutionOffer')->nullable();
            $table->boolean('canEditSolution')->nullable();
            $table->boolean('canDeleteSolution')->nullable();
            $table->boolean('showSolutions')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

        });

        Schema::table('technical_details', function (Blueprint $table) {

            $table->unsignedBigInteger('challenge_id')->nullable()->change();
            $table->unsignedBigInteger('solution_id')->nullable()->change();

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('solution_id')->references('id')->on('solutions');

        });

        Schema::table('user_companies', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('company_id')->change();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');

        });

        Schema::table('users', function (Blueprint $table) {

            $table
                ->foreign('love_reacter_id')
                ->references('id')
                ->on('love_reacters');

        });

        Schema::table('user_workshop_objects', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('workshop_object_id')->change();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('workshop_object_id')->references('id')->on('workshop_objects');

        });

        Schema::table('workshop_objects', function (Blueprint $table) {

            $table->unsignedBigInteger('author_id')->change();
            $table->foreign('author_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
