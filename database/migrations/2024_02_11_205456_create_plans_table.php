<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('translations')->nullable();
            $table->float('monthly_price')->default(0);
            $table->float('annual_price')->default(0);
            $table->float('lifetime_price')->default(0);
            $table->text('settings');
            $table->boolean('recommended')->default(false);
            $table->integer('position')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0:inactive, 1:active, 2:hidden');
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
        Schema::dropIfExists('plans');
    }
};
