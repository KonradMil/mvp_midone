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




        Schema::create('notifications', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

        });


        Schema::create('password_resets', function (Blueprint $table) {

            $table->string('email')->index();
            $table->string('token');
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


        Schema::create('team_user', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('team_id');
            $table->timestamps();

            $table->index('user_id', 'team_user_user_id_foreign');
            $table->index('team_id', 'team_user_team_id_foreign');

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


    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('estimates');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('files');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('team_invites');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('user_companies');
        Schema::dropIfExists('users');
    }

}
