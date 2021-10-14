<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

        $results = DB::select(
            "SELECT _ci.id FROM challenge_image _ci
                    LEFT JOIN challenges _c ON _c.id = _ci.challenge_id
	                WHERE _c.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM challenge_image WHERE id = '.$row->id);
        }

        Schema::table('challenge_image', function (Blueprint $table) {
            $table->unsignedBigInteger('challenge_id')->index()->change();
            $table->unsignedBigInteger('image_id')->index()->change();
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('image_id')->references('id')->on('files');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->change();
            $table->foreign('author_id')->references('id')->on('users');
        });

        $results = DB::select(
            "SELECT e.id FROM estimates e
                    LEFT JOIN solutions s ON s.id = e.solution_id
                    WHERE s.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM estimates WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT lrrc.id FROM love_reactant_reaction_counters lrrc
                    LEFT JOIN love_reactants lr ON lr.id = lrrc.reactant_id
                    WHERE lr.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM love_reactant_reaction_counters WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT lrrt.id FROM love_reactant_reaction_totals lrrt
                    LEFT JOIN love_reactants lr ON lr.id = lrrt.reactant_id
                    WHERE lr.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM love_reactant_reaction_totals WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT o.id FROM offers o
                    LEFT JOIN challenges c ON c.id = o.challenge_id
                    WHERE c.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM offers WHERE id = '.$row->id);
        }

        $results = DB::select(
            "SELECT o.id FROM offers o
                    LEFT JOIN solutions s ON s.id = o.solution_id
                    WHERE s.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM offers WHERE id = '.$row->id);
        }

        $results = DB::select(
            "SELECT o.id FROM offers o
                    LEFT JOIN users u ON u.id = o.installer_id
                    WHERE u.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM offers WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT q.id FROM questions q
                    LEFT JOIN users u ON u.id = q.author_id
                    WHERE u.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM questions WHERE id = '.$row->id);
        }

        $results = DB::select(
            "SELECT q.id FROM questions q
                    LEFT JOIN challenges c ON c.id = q.challenge_id
                    WHERE c.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM questions WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT tc.id FROM team_challenge tc
                    LEFT JOIN challenges c ON c.id = tc.challenge_id
                    WHERE c.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM team_challenge WHERE id = '.$row->id);
        }

        $results = DB::select(
            "SELECT tc.id FROM team_challenge tc
                    LEFT JOIN teams t ON t.id = tc.team_id
                    WHERE t.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM team_challenge WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT ts.id FROM team_solution ts
                    LEFT JOIN solutions s ON s.id = ts.solution_id
                    WHERE s.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM team_solution WHERE id = '.$row->id);
        }

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

        $results = DB::select(
            "SELECT td.id FROM technical_details td
                    LEFT JOIN challenges c ON c.id = td.challenge_id
                    WHERE c.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM technical_details WHERE id = '.$row->id);
        }

        Schema::table('technical_details', function (Blueprint $table) {

            $table->unsignedBigInteger('challenge_id')->nullable()->change();
            $table->unsignedBigInteger('solution_id')->nullable()->change();

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('solution_id')->references('id')->on('solutions');

        });

        $results = DB::select(
            "SELECT uc.id FROM user_companies uc
                    LEFT JOIN users u ON u.id = uc.user_id
                    WHERE u.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM user_companies WHERE id = '.$row->id);
        }

        $results = DB::select(
            "SELECT uc.id FROM user_companies uc
                    LEFT JOIN companies c ON c.id = uc.company_id
                    WHERE c.id is null"
        );

        foreach($results as $row) {
            DB::delete('DELETE FROM user_companies WHERE id = '.$row->id);
        }

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

        $result = DB::select("
            select u.id from users u
            left join user_companies uc on uc.user_id = u.id
            where uc.id is null
        ");

        foreach($result as $row){

            $user = User::find($row->id);

            $company = Company::create([
                'author_id' => $user->id
            ]);

            $company->users()->attach($user);

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenge_files', function (Blueprint $table) {
            $table->dropForeign('challenge_files_challenge_id_foreign');
            $table->dropForeign('challenge_files_file_id_foreign');
        });

        Schema::table('challenge_files', function (Blueprint $table) {
            $table->integer('challenge_id')->change();
            $table->dropColumn('image_id');
            $table->integer('file_id')->change();
        });


        Schema::table('challenge_image', function (Blueprint $table) {
            $table->dropForeign('challenge_image_challenge_id_foreign');
            $table->dropForeign('challenge_image_image_id_foreign');
        });

        Schema::table('challenge_image', function (Blueprint $table) {
            $table->integer('challenge_id')->change();
            $table->integer('image_id')->change();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_author_id_foreign');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->integer('author_id')->change();
        });

        Schema::table('estimates', function (Blueprint $table) {

            $table->dropForeign('estimates_solution_id_foreign');

        });

        Schema::table('estimates', function (Blueprint $table) {

            $table->integer('solution_id')->change();
            $table->dropColumn('parts_ar');

        });

        Schema::table('knowledgebase_videos', function (Blueprint $table) {

            $table->dropForeign('knowledgebase_videos_love_reactant_id_foreign');
            $table->dropColumn('en_name');
            $table->dropColumn('en_description');

        });

        Schema::table((new ReactionCounter())->getTable(), function (Blueprint $table) {

            $table->dropForeign('love_reactant_reaction_counters_reactant_id_foreign');
            $table->dropForeign('love_reactant_reaction_counters_reaction_type_id_foreign');

        });

        Schema::table((new ReactionTotal())->getTable(), function (Blueprint $table) {

            $table->dropForeign('love_reactant_reaction_totals_reactant_id_foreign');

        });

        Schema::table((new Reaction)->getTable(), function (Blueprint $table) {

            $table->dropForeign('love_reactions_reactant_id_foreign');
            $table->dropForeign('love_reactions_reacter_id_foreign');
            $table->dropForeign('love_reactions_reaction_type_id_foreign');

        });

        Schema::table('offers', function (Blueprint $table) {

            $table->dropForeign('offers_challenge_id_foreign');
            $table->dropForeign('offers_installer_id_foreign');
            $table->dropForeign('offers_solution_id_foreign');

        });

        Schema::table('offers', function (Blueprint $table) {

            $table->unsignedInteger('challenge_id')->nullable()->default(0)->change();
            $table->unsignedInteger('solution_id')->nullable()->default(1)->change();
            $table->unsignedInteger('installer_id')->nullable()->change();
            $table->unsignedInteger('price_of_delivery')->nullable()->default(1)->change();
            $table->integer('selected')->nullable()->change();
            $table->integer('rejected')->nullable()->change();

        });

        Schema::table('questions', function (Blueprint $table) {

            $table->dropForeign('questions_author_id_foreign');
            $table->dropForeign('questions_challenge_id_foreign');

        });

        Schema::table('questions', function (Blueprint $table) {

            $table->integer('author_id')->nullable()->change();
            $table->integer('challenge_id')->change();

        });

        Schema::table('ratings', function (Blueprint $table) {

            $table->dropForeign('ratings_user_id_foreign');

        });

        Schema::table('solutions', function (Blueprint $table) {

            $table->dropForeign('solutions_author_id_foreign');
            $table->dropForeign('solutions_challenge_id_foreign');
            $table->dropForeign('solutions_financial_after_id_foreign');
            $table->dropForeign('solutions_installer_id_foreign');
            $table->dropForeign('solutions_love_reactant_id_foreign');

        });

        Schema::table('solutions', function (Blueprint $table) {

            $table->integer('author_id')->change();
            $table->integer('challenge_id')->change();
            $table->integer('installer_id')->nullable()->change();
            $table->integer('financial_after_id')->nullable()->change();
            $table->dropColumn('en_name');
            $table->dropColumn('en_description');

        });

        Schema::table('taggables', function (Blueprint $table) {

            $table->dropForeign('taggables_tag_id_foreign');

        });

        Schema::table('team_challenge', function (Blueprint $table) {

            $table->dropForeign('team_challenge_challenge_id_foreign');
            $table->dropForeign('team_challenge_team_id_foreign');

        });

        Schema::table('team_challenge', function (Blueprint $table) {

            $table->integer('challenge_id')->change();
            $table->integer('team_id')->change();

        });

        Schema::table('team_invites', function (Blueprint $table) {

            $table->dropForeign('team_invites_team_id_foreign');

        });

        Schema::table('team_solution', function (Blueprint $table) {

            $table->dropForeign('team_solution_solution_id_foreign');
            $table->dropForeign('team_solution_team_id_foreign');

        });

        Schema::table('team_solution', function (Blueprint $table) {

            $table->integer('solution_id')->change();
            $table->integer('team_id')->change();

        });

        Schema::table('team_user', function (Blueprint $table) {

            $table->dropForeign('team_user_team_id_foreign');
            $table->dropForeign('team_user_user_id_foreign');

        });

        Schema::table('team_user', function (Blueprint $table) {

            $table->dropColumn('owner');
            $table->dropColumn('publishChallenge');
            $table->dropColumn('editChallenge');
            $table->dropColumn('acceptChallengeSolution');
            $table->dropColumn('acceptChallengeOffer');
            $table->dropColumn('publishSolution');
            $table->dropColumn('addSolutionOffer');
            $table->dropColumn('canEditSolution');
            $table->dropColumn('canDeleteSolution');
            $table->dropColumn('showSolutions');

        });

        Schema::table('technical_details', function (Blueprint $table) {

            $table->dropForeign('technical_details_challenge_id_foreign');
            $table->dropForeign('technical_details_solution_id_foreign');

        });

        Schema::table('technical_details', function (Blueprint $table) {

            $table->integer('challenge_id')->nullable()->change();
            $table->integer('solution_id')->nullable()->change();

        });

        Schema::table('user_companies', function (Blueprint $table) {

            $table->dropForeign('user_companies_company_id_foreign');
            $table->dropForeign('user_companies_user_id_foreign');

        });

        Schema::table('user_companies', function (Blueprint $table) {

            $table->integer('user_id')->change();
            $table->integer('company_id')->change();

        });

        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign('users_love_reacter_id_foreign');

        });

        Schema::table('user_workshop_objects', function (Blueprint $table) {

            $table->dropForeign('user_workshop_objects_user_id_foreign');
            $table->dropForeign('user_workshop_objects_workshop_object_id_foreign');

        });

        Schema::table('user_workshop_objects', function (Blueprint $table) {

            $table->integer('user_id')->change();
            $table->integer('workshop_object_id')->change();

        });

        Schema::table('workshop_objects', function (Blueprint $table) {

            $table->dropForeign('workshop_objects_author_id_foreign');

        });

        Schema::table('workshop_objects', function (Blueprint $table) {

            $table->integer('author_id')->change();

        });

    }
}
