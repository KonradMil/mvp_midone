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

        Schema::connection(config('activitylog.database_connection'))->create('activity_log', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->timestamps();
            $table->index('log_name');

        });

        Schema::create('challenge_files', function (Blueprint $table) {

            $table->id();
            $table->integer('challenge_id');
            $table->integer('file_id');
            $table->integer('type')->default(1);
            $table->timestamps();

        });

        Schema::create('challenge_image', function (Blueprint $table) {

            $table->id();
            $table->integer('challenge_id');
            $table->integer('image_id');
            $table->timestamps();

        });

        Schema::create('challenges', function (Blueprint $table) {

            $table->id();
            $table->integer('type');
            $table->string('name', 255)->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('solution_deadline');
            $table->timestamp('offer_deadline');
            $table->integer('status');
            $table->integer('stage');
            $table->longText('save_json')->nullable();
            $table->string('screenshot_path', 255)->nullable();
            $table->integer('author_id');
            $table->integer('financial_before_id');
            $table->timestamps();
            $table->unsignedBigInteger('love_reactant_id')->nullable();
            $table->integer('allowed_publishing')->nullable();
            $table->unsignedBigInteger('technical_details_id')->nullable();
            $table->unsignedBigInteger('selected_offer_id')->nullable();

            $table->index('love_reactant_id', 'challenges_love_reactant_id_foreign');

        });

        Schema::create('comments', function (Blueprint $table) {

            $table->increments('id');
            $table->morphs('commentable');
            $table->text('comment');
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('user_id')->nullable();
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
            $table->integer('author_id');
            $table->timestamps();

        });

        Schema::create('estimates', function (Blueprint $table) {

            $table->id();
            $table->integer('solution_id');
            $table->double('integration_cost', 8, 2);
            $table->double('parts_cost', 8, 2);
            $table->double('mechanical_integration', 8, 2);
            $table->double('electrical_integration', 8, 2);
            $table->double('workstation_integration', 8, 2);
            $table->double('programming_robot', 8, 2);
            $table->double('programming_plc', 8, 2);
            $table->double('documentation_ce', 8, 2);
            $table->double('training', 8, 2);
            $table->double('project', 8, 2);
            $table->double('margin', 8, 2);
            $table->json('parts_prices');
            $table->json('additional_costs');
            $table->double('sum');
            $table->timestamps();

        });

        Schema::create('failed_jobs', function (Blueprint $table) {

            $table->id();
            $table->string('uuid', 255)->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();

        });

        Schema::create('file_reports', function (Blueprint $table) {

            $table->id();
            $table->integer('report_id');
            $table->integer('file_id');
            $table->timestamps();

        });

        Schema::create('files', function (Blueprint $table) {

            $table->id();
            $table->string('name')->nullable();
            $table->string('ext', 255);
            $table->string('original_name', 255);
            $table->string('path', 255);
            $table->string('thumbnail', 255)->nullable();
            $table->string('size', 255)->nullable();
            $table->string('alt', 255)->nullable();
            $table->timestamps();

        });

        Schema::create('financials', function (Blueprint $table) {

            $table->id();
            $table->integer('days')->default(260);
            $table->integer('shifts')->default(4);
            $table->integer('shift_time')->default(8);
            $table->integer('weekend_shift')->default(0);
            $table->integer('breakfast')->default(30);
            $table->integer('stop_time')->default(20);
            $table->integer('operator_performance')->default(90);
            $table->integer('defective')->default(5);
            $table->integer('number_of_operators')->default(2);
            $table->integer('operator_cost')->default(4500);
            $table->integer('absence')->default(12);
            $table->integer('cycle_time')->nullable();
            $table->timestamps();
            $table->integer('challenge_id')->nullable();

        });

        Schema::create('jobs', function (Blueprint $table) {

            $table->id();
            $table->string('queue', 255);
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');

            $table->index('queue');

        });

        Schema::create('knowledgebase_videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('src');
            $table->string('poster');
            $table->string('description');
            $table->integer('category');
            $table->integer('published');
            $table->string('video_id');
            $table->timestamps();
            $table->unsignedBigInteger('love_reactant_id')->nullable();

            $table->index('love_reactant_id', 'knowledgebase_videos_love_reactant_id_foreign');
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

            $table->index('reaction_type_id', 'love_reactant_reaction_counters_reaction_type_id_foreign');

        });

        Schema::create((new ReactionTotal())->getTable(), function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('reactant_id');
            $table->unsignedBigInteger('count');
            $table->decimal('weight', 13, 2);
            $table->timestamps();

            $table->index('reactant_id', 'love_reactant_reaction_totals_reactant_id_foreign');

        });

        Schema::create((new Reactant)->getTable(), function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();

            $table->index('type');

        });

        Schema::create((new Reacter())->getTable(), function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();

            $table->index('type');

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

            $table->index('reaction_type_id', 'love_reactions_reaction_type_id_foreign');

        });

        Schema::create((new ReactionType())->getTable(), function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->tinyInteger('mass');
            $table->timestamps();

            $table->index('name');

        });

        Schema::create('models', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->integer('category');
            $table->integer('subcategory');
            $table->double('price', 8, 2)->nullable();
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

            $table->index('category', 'category');
            $table->index('subcategory', 'subcategory');

        });

        Schema::create('notifications', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

        });

        Schema::create('offers', function (Blueprint $table) {

            $table->id();
            $table->unsignedInteger('challenge_id')->nullable()->default(0);
            $table->unsignedInteger('solution_id')->nullable()->default(1);
            $table->unsignedInteger('installer_id')->nullable();
            $table->unsignedInteger('price_of_delivery')->nullable()->default(1);
            $table->integer('weeks_to_start')->nullable();
            $table->integer('time_to_start')->nullable()->default(1);
            $table->integer('time_to_fix')->nullable()->default(0);
            $table->integer('advance_upon_start')->nullable()->default(0);
            $table->integer('advance_upon_delivery')->nullable()->default(0);
            $table->integer('advance_upon_agreement')->nullable()->default(1);
            $table->integer('selected')->nullable();
            $table->integer('rejected')->nullable();
            $table->string('years_of_guarantee')->nullable()->default("0");
            $table->integer('service_support_scope')->nullable()->default(1);
            $table->string('maintenance_frequency')->nullable()->default("1");
            $table->float('price_of_maintenance')->nullable();
            $table->string('reaction_time')->nullable();
            $table->float('intervention_price')->nullable();
            $table->float('work_hour_price')->nullable();
            $table->string('period_of_support', 155)->nullable();
            $table->integer('offer_expires_in')->nullable()->default(30);
            $table->integer('status')->nullable()->default(0);
            $table->float('avg_guarantee')->nullable();
            $table->longText('robots')->nullable();
            $table->float('points')->nullable();
            $table->timestamps();

        });

        Schema::create('password_resets', function (Blueprint $table) {

            $table->string('email')->index();
            $table->string('token');
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

        Schema::create('questions', function (Blueprint $table) {

            $table->id();
            $table->longText('question')->nullable();
            $table->longText('answer')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('challenge_id');
            $table->timestamps();

        });

        Schema::create('ratings', function (Blueprint $table) {

            $table->unsignedInteger('id')->autoIncrement();
            $table->timestamps();
            $table->integer('rating');
            $table->morphs('rateable');
            $table->unsignedBigInteger('user_id');
            $table->index('rateable_id');
            $table->index('rateable_type');
            $table->index('user_id', 'ratings_user_id_foreign');

        });

        Schema::create('reports', function (Blueprint $table) {

            $table->id();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->integer('author_id')->nullable();
            $table->timestamps();

        });

        Schema::create('solutions', function (Blueprint $table) {

            $table->id();
            $table->timestamp('deadline_offered')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->integer('author_id');
            $table->integer('challenge_id');
            $table->integer('installer_id')->nullable();
            $table->integer('financial_after_id')->nullable();
            $table->longText('save_json')->nullable();
            $table->integer('selected_offer_id')->nullable();
            $table->integer('selected')->nullable();
            $table->integer('rejected')->nullable();
            $table->string('name')->nullable()->default('Rozwiązanie');
            $table->string('screenshot_path')->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('status');
            $table->tinyInteger('archive')->nullable();
            $table->integer('published');
            $table->integer('number_of_fanuc')->default(0);
            $table->integer('number_of_yaskawa')->default(0);
            $table->integer('number_of_abb')->default(0);
            $table->integer('number_of_mitshubishi')->default(0);
            $table->integer('number_of_kuka')->default(0);
            $table->integer('number_of_tfm')->default(0);
            $table->integer('number_of_universal')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('love_reactant_id')->nullable();

            $table->index('love_reactant_id', 'solutions_love_reactant_id_foreign');
        });

        Schema::create('taggables', function (Blueprint $table) {

            $table->unsignedBigInteger('tag_id');
            $table->morphs('taggable');

            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->string('type')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('team_challenge', function (Blueprint $table) {
            $table->id();
            $table->integer('challenge_id');
            $table->integer('team_id');
            $table->timestamps();
        });

        Schema::create('team_invites', function (Blueprint $table) {

            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('team_id');
            $table->enum('type', ['invite', 'request']);
            $table->string('email');
            $table->string('accept_token');
            $table->string('deny_token');
            $table->timestamps();

            $table->index('team_id', 'team_invites_team_id_foreign');

        });

        Schema::create('teams', function (Blueprint $table) {

            $table->increments('id')->unsigned();
            $table->unsignedInteger('owner_id')->nullable();
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('team_solution', function (Blueprint $table) {

            $table->id();
            $table->integer('solution_id');
            $table->integer('team_id');
            $table->timestamps();

        });

        Schema::create('team_user', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('team_id');
            $table->timestamps();

            $table->index('user_id', 'team_user_user_id_foreign');
            $table->index('team_id', 'team_user_team_id_foreign');

        });

        Schema::create('technical_details', function (Blueprint $table) {

            $table->id();
            $table->integer('challenge_id')->nullable();
            $table->integer('solution_id')->nullable();
            $table->integer('detail_weight')->default(0);
            $table->integer('pick_quality')->default(0);
            $table->integer('detail_material')->default(0);
            $table->integer('detail_size')->default(0);
            $table->integer('detail_pick')->default(0);
            $table->integer('detail_position')->default(0);
            $table->integer('detail_range')->default(0);
            $table->integer('detail_destination')->default(0);
            $table->integer('number_of_lines')->default(1);
            $table->integer('cycle_time')->default(0);
            $table->integer('work_shifts')->default(0);
            $table->timestamps();

        });

        Schema::create('user_companies', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->timestamps();

        });

        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
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
            $table->integer('new_answer')->nullable();
            $table->integer('solution_accepted')->nullable();
            $table->integer('offer_accepted')->nullable();

            $table->string('password');
            $table->rememberToken();

            //TWO FACTOR AUTH
            $table->integer('twofa')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('love_reacter_id')->nullable();
            $table->unsignedInteger('current_team_id')->nullable();

            $table->index('love_reacter_id', 'users_love_reacter_id_foreign');

        });

        Schema::create('user_workshop_objects', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id');
            $table->integer('workshop_object_id');
            $table->timestamps();

        });

        Schema::create('workshop_objects', function (Blueprint $table) {

            $table->id();
            $table->string('name')->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('type')->nullable();
            $table->json('save')->nullable();
            $table->integer('author_id');
            $table->integer('public')->nullable();
            $table->string('screenshot_path');
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
        Schema::connection(config('activitylog.database_connection'))->dropIfExists('activity_log');
        Schema::dropIfExists('challenge_files');
        Schema::dropIfExists('challenge_image');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('estimates');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('file_reports');
        Schema::dropIfExists('files');
        Schema::dropIfExists('financials');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('knowledgebase_videos');
        Schema::dropIfExists((new ReactionCounter())->getTable());
        Schema::dropIfExists((new ReactionTotal())->getTable());
        Schema::dropIfExists((new Reactant())->getTable());
        Schema::dropIfExists((new Reacter())->getTable());
        Schema::dropIfExists((new Reaction())->getTable());
        Schema::dropIfExists((new ReactionType())->getTable());
        Schema::dropIfExists('models');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('solutions');
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('team_challenge');
        Schema::dropIfExists('team_invites');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_solution');
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('technical_details');
        Schema::dropIfExists('user_companies');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_workshop_objects');
        Schema::dropIfExists('workshop_objects');
    }

}
