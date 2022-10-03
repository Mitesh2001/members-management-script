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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->date('new_validity_date')->nullable();
            $table->tinyInteger('status')->comment('1: draft, 2: open, 3:paid, 4: uncollectible, or void')->default(4);
            $table->string('webhook_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
