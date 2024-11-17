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
        Schema::create('post_links', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('post_id')->index('post_id');
            $table->string('type', 32)->nullable();
            $table->longText('settings')->nullable();
            $table->boolean('active')->default(true);
            $table->bigInteger('click')->default(0);
            $table->bigInteger('position')->nullable()->default(999);
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
        Schema::dropIfExists('post_links');
    }
};
