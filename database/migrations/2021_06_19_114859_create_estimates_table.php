<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->integer('solution_id');
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
        Schema::dropIfExists('estimates');
    }
}
