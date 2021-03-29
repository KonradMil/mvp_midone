<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
