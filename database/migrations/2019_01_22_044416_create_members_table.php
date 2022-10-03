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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_number')->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(0)->comment('0: Inactive, 1: Active');
            $table->tinyInteger('gender')->nullable()->comment('1: Male, 2: Female');
            $table->date('member_since');
            $table->bigInteger('referred_by')->unsigned()->nullable();
            $table->bigInteger('membership_plan_id')->unsigned()->nullable();
            $table->integer('height')->nullable();
            $table->date('validity_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('referred_by')->references('id')->on('members');
            $table->foreign('membership_plan_id')->references('id')->on('membership_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
