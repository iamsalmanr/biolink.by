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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 100);
            $table->string('name', 100);
            $table->string('logo');
            $table->integer('fees');
            $table->text('credentials');
            $table->boolean('test_mode')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        $payment_gateways = array(
            array('id' => '1','name' => 'Paypal','key' => 'paypal','logo' => 'paypal.png','fees' => '0','test_mode' => '1','credentials' => '{"client_id":"","client_secret":"","app_id":""}','status' => '1'),
            array('id' => '2','name' => 'Stripe','key' => 'stripe','logo' => 'stripe.png','fees' => '0','test_mode' => NULL,'credentials' => '{"publishable_key":"","secret_key":""}','status' => '1'),
            array('id' => '3','name' => 'Mollie','key' => 'mollie','logo' => 'mollie.png','fees' => '0','test_mode' => NULL,'credentials' => '{"api_key":""}','status' => '1'),
            array('id' => '4','name' => 'Razorpay','key' => 'razorpay','logo' => 'razorpay.png','fees' => '0','test_mode' => NULL,'credentials' => '{"key_id":"","key_secret":""}','status' => '1')
        );


        DB::table('payment_gateways')->insert($payment_gateways);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
};
