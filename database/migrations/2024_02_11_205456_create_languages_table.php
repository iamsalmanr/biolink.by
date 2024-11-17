<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('flag');
            $table->string('code', 10)->unique();
            $table->tinyInteger('direction')->comment('1:LTR 2:RTL');
            $table->boolean('active')->default(true);
            $table->integer('position');
            $table->timestamps();
        });

        $languages = array(
            array('name' => 'English','flag' => 'en.png','code' => 'en','direction' => '2','position' => '0','active' => '1'),
            array('name' => 'French','flag' => 'fr.png','code' => 'fr','direction' => '1','position' => '2','active' => '1')
        );

        DB::table('languages')->insert($languages);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
