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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('plan_id')->index('plan_id');
            $table->text('details')->nullable();
            $table->float('total');
            $table->text('coupon')->nullable();
            $table->text('taxes')->nullable();
            $table->float('fees')->default(0);
            $table->text('customer')->nullable();
            $table->text('seller')->nullable();
            $table->unsignedBigInteger('gateway')->nullable()->index('gateway');
            $table->string('payment_id')->nullable();
            $table->string('status',20)->nullable();
            $table->boolean('is_viewed')->default(false);
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
        Schema::dropIfExists('transactions');
    }
};
