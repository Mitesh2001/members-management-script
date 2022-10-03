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
        Schema::create('member_timing', function (Blueprint $table) {
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('timing_id')->unsigned();

            $table->primary(['member_id', 'timing_id']);
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('timing_id')->references('id')->on('timings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_timing');
    }
};
