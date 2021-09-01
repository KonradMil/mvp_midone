<?php

use Cog\Laravel\Love\Reactant\Models\Reactant;
use Cog\Laravel\Love\Reactant\ReactionCounter\Models\ReactionCounter;
use Cog\Laravel\Love\Reactant\ReactionTotal\Models\ReactionTotal;
use Cog\Laravel\Love\Reacter\Models\Reacter;
use Cog\Laravel\Love\Reaction\Models\Reaction;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->integer('verified')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('type');
            $table->integer('admin')->default(0);
            $table->string('avatar')->nullable();
            //RODO
            $table->integer('privacy_policy')->default(1);
            $table->integer('pricing')->default(1);
            $table->integer('terms')->default(1);
            //NOTIFICATIONS
            $table->integer('new_answer')->default(0);
            $table->integer('solution_accepted')->default(0);
            $table->integer('offer_accepted')->default(0);
            //TWO FACTOR AUTH
            $table->integer('twofa')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category');
            $table->integer('subcategory');
            $table->float('price')->nullable();
            $table->string('model_file');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('max_load_kg')->nullable();
            $table->string('max_range_mm')->nullable();
            $table->string('axis')->nullable();
            $table->string('max_speed_mms')->nullable();
            $table->string('tech_sheet')->nullable();
            $table->string('connection_method')->nullable();
            $table->string('range')->nullable();
            $table->string('repetity')->nullable();
            $table->string('load')->nullable();
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 70)->nullable();
            $table->string('country', 70)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('house_nr', 5)->nullable();
            $table->string('flat_nr', 5)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('nip', 12)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 18)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('regon', 20)->nullable();
            $table->string('krs', 20)->nullable();
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('user_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('ext');
            $table->string('original_name');
            $table->string('path');
            $table->string('thumbnail')->nullable();
            $table->string('size')->nullable();
            $table->string('alt')->nullable();
            $table->timestamps();
        });

        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->integer('days')->default(260);
            $table->integer('shifts')->default(30);
            $table->integer('shift_time')->default(8);
            $table->integer('weekend_shift')->default(0);
            $table->integer('breakfast')->default(30);
            $table->integer('stop_time')->default(20);
            $table->integer('operator_performance')->default(90);
            $table->integer('defective')->default(5);
            $table->integer('number_of_operators')->default(2);
            $table->integer('operator_cost')->default(4500);
            $table->integer('absence')->default(12);
            $table->integer('challenge_id')->nullable();
            $table->integer('cycle_time')->nullable();
            $table->timestamps();
        });

        Schema::create('technical_details', function (Blueprint $table) {
            $table->id();
            $table->integer('detail_weight')->nullable();
            $table->integer('pick_quality');
            $table->integer('detail_material');
            $table->integer('detail_size');
            $table->integer('detail_pick');
            $table->integer('detail_position');
            $table->integer('detail_range');
            $table->integer('detail_destination');
            $table->integer('number_of_lines');
            $table->integer('cycle_time');
            $table->integer('work_shifts');
            $table->timestamps();
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->float('price_of_delivery')->default(0);
            $table->integer('weeks_to_start')->default(0);
            $table->integer('time_to_start')->default(1);
            $table->integer('time_to_fix')->default(0);
            $table->integer('advance_upon_start')->default(0);
            $table->integer('advance_upon_delivery')->default(0);
            $table->integer('advance_upon_agreement')->default(0);
            $table->string('years_of_guarantee')->default(0);
            $table->integer('service_support_scope')->default(1);
            $table->string('maintenance_frequency')->default(1);
            $table->float('price_of_maintenance')->default(1);
            $table->string('reaction_time')->default(1);
            $table->float('intervention_price')->default(1);
            $table->float('work_hour_price')->default(1);
            $table->string('period_of_support')->default(1);
            $table->integer('offer_expires_in')->default(30);
            $table->longText('robots');
            $table->integer('status')->default(0);
            $table->float('avg_guarantee')->default(0);
            $table->float('points')->default(0);
            $table->boolean('selected')->default(false);
            $table->boolean('rejected')->default(false);

            $table->timestamps();
        });

        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('name')->nullable();
            $table->string('en_name')->nullable();
            $table->string('description')->nullable();
            $table->string('en_description')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->longText('save_json')->nullable();
            $table->integer('status')->default(0);
            $table->integer('stage')->nullable();
            $table->integer('published')->default(0);
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('financial_before_id');
            $table->unsignedBigInteger('technical_details_id');
            $table->unsignedBigInteger('selected_offer_id');
            $table->unsignedBigInteger('solution_project_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('financial_before_id')->references('id')->on('financials');
            $table->foreign('technical_details_id')->references('id')->on('technical_details');
            $table->foreign('selected_offer_id')->references('id')->on('offers');

            $table->timestamp('solution_deadline');
            $table->timestamp('offer_deadline');
            $table->timestamps();
        });

        Schema::create('challenge_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('image_id');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('image_id')->references('id')->on('files');
            $table->timestamps();
        });

        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Rozwiązanie');
            $table->string('en_name')->default('Solution');
            $table->string('screenshot_path');
            $table->mediumText('description')->nullable();
            $table->mediumText('en_description')->nullable();
            $table->float('price')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('installer_id');
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('financial_after_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('installer_id')->references('id')->on('users');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('financial_after_id')->references('id')->on('financials');
            $table->integer('status')->default(0);
            $table->integer('published')->default(0);
            $table->integer('archived')->default(0);
            $table->integer('selected')->default(0);
            $table->integer('rejected')->default(0);
            $table->integer('number_of_fanuc')->default(0);
            $table->integer('number_of_yaskawa')->default(0);
            $table->integer('number_of_abb')->default(0);
            $table->integer('number_of_mitshubishi')->default(0);
            $table->integer('number_of_kuka')->default(0);
            $table->integer('number_of_tfm')->default(0);
            $table->integer('number_of_universal');
            $table->longText('save_json')->nullable();
            $table->timestamp('deadline_offered')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->foreign('solution_project_id')->references('id')->on('solutions');
        });

        Schema::create('solution_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->unsignedBigInteger('image_id');
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->foreign('image_id')->references('id')->on('files');
            $table->timestamps();
        });

        Schema::table('technical_details', function (Blueprint $table) {
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('solution_id');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('solution_id')->references('id')->on('solutions');

        });

        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('solution_id');
            $table->unsignedBigInteger('installer_id');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->foreign('installer_id')->references('id')->on('users');
        });

        Schema::create('challenge_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('file_id');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('file_id')->references('id')->on('files');
            $table->integer('type')->default(1);
            $table->timestamps();
        });

        Schema::create('knowledgebase_videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('en_name');
            $table->string('src');
            $table->string('poster');
            $table->string('en_description');
            $table->integer('category');
            $table->integer('published');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->string('type')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');

            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('rating');
            $table->morphs('rateable');
            $table->index('rateable_id');
            $table->index('rateable_type');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('commentable');
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('current_team_id')->unsigned()->nullable();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->integer('team_id')->unsigned();

            //Kolumny powinny nazywać się tak, aby nazwy wskazywały na to do czego służą np: is_owner, can_edit_challenges, can_publish_solutions
            $table->boolean('owner');
            $table->boolean('publishChallenge');
            $table->boolean('editChallenge');
            $table->boolean('acceptChallengeSolution');
            $table->boolean('acceptChallengeOffer');
            $table->boolean('publishSolution');
            $table->boolean('addSolutionOffer');
            $table->boolean('canEditSolution');
            $table->boolean('canDeleteSolution');
            $table->boolean('showSolutions');
            $table->timestamps();

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

        Schema::create('team_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->enum('type', ['invite', 'request']);
            $table->string('email');
            $table->string('accept_token');
            $table->string('deny_token');
            $table->timestamps();
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
        });

        Schema::create('team_challenge', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedInteger('team_id');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });

        Schema::create('team_solution', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->unsignedInteger('team_id');
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->longText('question')->nullable();
            $table->longText('answer')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('challenge_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('wp_id')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->integer('type_investor', false)->nullable();
            $table->integer('type_installer', false)->nullable();
            $table->text('excerpt')->nullable();
            $table->text('thumbnail')->nullable();
            $table->mediumText('content')->nullable();
            $table->timestamps();
        });

        Schema::create('workshop_objects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('save')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('user_workshop_objects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workshop_object_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('workshop_object_id')->references('id')->on('workshop_objects');
            $table->timestamps();
        });

        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->float('sum');
            $table->float('integration_cost');
            $table->float('parts_cost');
            $table->float('mechanical_integration');
            $table->float('electrical_integration');
            $table->float('workstation_integration');
            $table->float('programming_robot');
            $table->float('programming_plc');
            $table->float('documentation_ce');
            $table->float('training');
            $table->float('project');
            $table->float('margin');
            $table->json('parts_prices');
            $table->json('additional_costs');
            $table->json('parts_ar');
            $table->timestamps();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('reports', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('description');
            $table->integer('author_id');
            $table->timestamps();

        });

        //LOVE REACTANTS
        Schema::create((new Reacter())->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();

            $table->index('type');
        });

        Schema::create((new Reactant)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();

            $table->index('type');
        });

        Schema::create((new ReactionType())->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->tinyInteger('mass');
            $table->timestamps();

            $table->index('name');
        });

        Schema::create((new Reaction())->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reactant_id');
            $table->unsignedBigInteger('reacter_id');
            $table->unsignedBigInteger('reaction_type_id');
            $table->decimal('rate', 4, 2);
            $table->timestamps();

            $table->index([
                'reactant_id',
                'reaction_type_id',
            ]);
            $table->index([
                'reactant_id',
                'reacter_id',
                'reaction_type_id',
            ]);
            $table->index([
                'reactant_id',
                'reacter_id',
            ]);
            $table->index([
                'reacter_id',
                'reaction_type_id',
            ]);

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

        Schema::create((new ReactionCounter())->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reactant_id');
            $table->unsignedBigInteger('reaction_type_id');
            $table->unsignedBigInteger('count');
            $table->decimal('weight', 13, 2);
            $table->timestamps();

            $table->index([
                'reactant_id',
                'reaction_type_id',
            ], 'love_reactant_reaction_counters_reactant_reaction_type_index');

            $table
                ->foreign('reactant_id')
                ->references('id')
                ->on('love_reactants')
                ->onDelete('cascade');
            $table
                ->foreign('reaction_type_id')
                ->references('id')
                ->on('love_reaction_types')
                ->onDelete('cascade');
        });

        Schema::create((new ReactionTotal())->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reactant_id');
            $table->unsignedBigInteger('count');
            $table->decimal('weight', 13, 2);
            $table->timestamps();

            $table
                ->foreign('reactant_id')
                ->references('id')
                ->on('love_reactants')
                ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('love_reacter_id')->nullable();

            $table
                ->foreign('love_reacter_id')
                ->references('id')
                ->on('love_reacters');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->unsignedBigInteger('love_reactant_id')->nullable();

            $table
                ->foreign('love_reactant_id')
                ->references('id')
                ->on('love_reactants');
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->unsignedBigInteger('love_reactant_id')->nullable();

            $table
                ->foreign('love_reactant_id')
                ->references('id')
                ->on('love_reactants');
        });

        Schema::table('knowledgebase_videos', function (Blueprint $table) {
            $table->unsignedBigInteger('love_reactant_id')->nullable();

            $table
                ->foreign('love_reactant_id')
                ->references('id')
                ->on('love_reactants');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['love_reacter_id']);
            $table->dropColumn('love_reacter_id');
        });
        Schema::table('solutions', function (Blueprint $table) {
            $table->dropForeign(['love_reactant_id']);
            $table->dropColumn('love_reactant_id');
        });
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign(['love_reactant_id']);
            $table->dropColumn('love_reactant_id');
        });
        Schema::table('knowledgebase_videos', function (Blueprint $table) {
            $table->dropForeign(['love_reactant_id']);
            $table->dropColumn('love_reactant_id');
        });
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('models');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('user_companies');
        Schema::dropIfExists('files');
        Schema::dropIfExists('financials');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('challenge_image');
        Schema::dropIfExists('solutions');
        Schema::dropIfExists('solution_image');
        Schema::dropIfExists('technical_details');
        Schema::dropIfExists('challenge_files');
        Schema::dropIfExists('knowledgebase_videos');
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('comments');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('current_team_id');
        });
        Schema::table('team_user', function (Blueprint $table) {
            $table->dropForeign('team_user' . '_user_id_foreign');
            $table->dropForeign('team_user' . '_team_id_foreign');
        });

        Schema::drop('team_user');
        Schema::drop('team_invites');
        Schema::drop('teams');
        Schema::dropIfExists('team_challenge');
        Schema::dropIfExists('team_solution');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('workshop_objects');
        Schema::dropIfExists('user_workshop_objects');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('estimates');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('reports');

        Schema::dropIfExists((new Reacter())->getTable());
        Schema::dropIfExists((new Reactant)->getTable());
        Schema::dropIfExists((new ReactionType())->getTable());
        Schema::dropIfExists((new Reaction())->getTable());
        Schema::dropIfExists((new ReactionCounter())->getTable());
        Schema::dropIfExists((new ReactionTotal())->getTable());
    }
}
