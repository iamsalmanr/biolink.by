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
        Schema::create('adsense', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->longText('code')->nullable();
            $table->string('size')->nullable();
            $table->boolean('status')->default(false);
            $table->string('position');
            $table->timestamps();
        });

        $advertisements = array(
            array('id' => '1','position' => 'Head Code','size' => NULL,'key' => 'head_code','code' => '','status' => '1'),
            array('id' => '2','position' => 'Home Pages (Top)','size' => 'Responsive','key' => 'home_page_top','code' => '<img src="https://via.placeholder.com/720x90" width="100%" height="100%">','status' => '0'),
            array('id' => '3','position' => 'Home Pages (Bottom)','size' => 'Responsive','key' => 'home_page_bottom','code' => '<img src="https://via.placeholder.com/720x90" width="100%" height="100%">','status' => '0'),
            array('id' => '4','position' => 'Blog Page (Top)','size' => 'Responsive','key' => 'blog_page_top','code' => '<img src="https://via.placeholder.com/720x90" width="100%" height="100%">','status' => '0'),
            array('id' => '5','position' => 'Blog Page (Bottom)','size' => 'Responsive','key' => 'blog_page_bottom','code' => '<img src="https://via.placeholder.com/720x90" width="100%" height="100%">','status' => '0')
        );

        DB::table('adsense')->insert($advertisements);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adsense');
    }
};
