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
        Schema::create('navbar_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lang', 10)->index('lang');
            $table->string('name', 100);
            $table->text('link');
            $table->unsignedBigInteger('parent_id')->nullable()->index('parent_id');
            $table->string('type', 100)->nullable();
            $table->bigInteger('order')->default(0);
            $table->timestamps();
        });

        $navbar_menu = array(
            array('name' => 'Home','link' => '/','lang' => 'en','parent_id' => NULL,'type' => 'header','order' => '1'),
            array('name' => 'Pricing','link' => '/pricing','lang' => 'en','parent_id' => NULL,'type' => 'header','order' => '2'),
            array('name' => 'Blog','link' => '/blog','lang' => 'en','parent_id' => NULL,'type' => 'header','order' => '3'),
            array('name' => 'Faqs','link' => '/faqs','lang' => 'en','parent_id' => NULL,'type' => 'header','order' => '4'),
            array('name' => 'Contact Us','link' => '/contact-us','lang' => 'en','parent_id' => NULL,'type' => 'header','order' => '5'),
            array('name' => 'More','link' => '#','lang' => 'en','parent_id' => NULL,'type' => 'header','order' => '6'),
            array('name' => 'Privacy policy','link' => '#','lang' => 'en','parent_id' => '11','type' => 'header','order' => '1'),
            array('name' => 'Home','link' => '/','lang' => 'en','parent_id' => NULL,'type' => 'footer','order' => '9'),
            array('name' => 'Blog','link' => '/blog','lang' => 'en','parent_id' => NULL,'type' => 'footer','order' => '10')
        );

        DB::table('navbar_menu')->insert($navbar_menu);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navbar_menu');
    }
};
