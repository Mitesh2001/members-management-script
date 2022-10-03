<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timing_trainer', function (Blueprint $table) {
            $table->bigInteger('timing_id')->unsigned();
            $table->bigInteger('trainer_id')->unsigned();

            $table->primary(['timing_id', 'trainer_id']);
            $table->foreign('timing_id')->references('id')->on('timings');
            $table->foreign('trainer_id')->references('id')->on('trainers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timing_trainer');
    }
};
