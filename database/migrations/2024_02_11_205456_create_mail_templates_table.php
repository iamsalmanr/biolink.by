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
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lang', 10)->index('lang');
            $table->string('key');
            $table->string('name');
            $table->string('subject');
            $table->longText('body');
            $table->boolean('status')->default(true);
        });

        $mail_templates = array(
            array('lang' => 'en', 'key' => 'password_reset', 'name' => 'Reset Password Email', 'subject' => 'Reset Password Notification', 'body' => '<p>Hello!</p><p>Follow this url to reset your password <a href="{{link}}">{{link}}</a></p><p>This password reset link will expire in <strong>{{expiry_time}}</strong> minutes. Ignore this email, If you did not request a password reset.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'en', 'key' => 'email_verification', 'name' => 'Email Verification Email', 'subject' => 'Verify Email Address', 'body' => '<p>Hello!</p><p>Thanks for registering.</p><p>Please activate your account by clicking on the link below.</p><p><a href="{{link}}">{{link}}</a></p><p>Regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'en', 'key' => 'subscription_about_expired', 'name' => 'Subscription About To Expired Email', 'subject' => 'Your subscription is about to expire', 'body' => '<p>Hi, <strong>{{username}}</strong></p><p>Your subscription on <strong>{{plan}}</strong> plan is about to expire on <strong>{{expiry_date}}</strong>.</p><p>Please renew your subscription before the expiration date. <a href="{{link}}">{{link}}</a></p><p>Have further questions? You can start chatting with the live support team.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'en', 'key' => 'subscription_expired', 'name' => 'Subscription Expired Email', 'subject' => 'Your subscription has been expired', 'body' => '<p>Hi, <strong>{{username}}</strong></p><p>Your subscription on <strong>{{plan}}</strong> plan has expired on <strong>{{expiry_date}}</strong>.</p><p>Please renew your subscription. <a href="{{link}}">{{link}}</a></p><p>Have further questions? You can start chatting with the live support team.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'fr', 'key' => 'password_reset', 'name' => 'Reset Password Email', 'subject' => 'Reset Password Notification', 'body' => '<p>Hello!</p><p>Follow this url to reset your password <a href="{{link}}">{{link}}</a></p><p>This password reset link will expire in <strong>{{expiry_time}}</strong> minutes. Ignore this email, If you did not request a password reset.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'fr', 'key' => 'email_verification', 'name' => 'Email Verification Email', 'subject' => 'Verify Email Address', 'body' => '<p>Hello!</p><p>Thanks for registering.</p><p>Please activate your account by clicking on the link below.</p><p><a href="{{link}}">{{link}}</a></p><p>Regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'fr', 'key' => 'subscription_about_expired', 'name' => 'Subscription About To Expired Email', 'subject' => 'Your subscription is about to expire', 'body' => '<p>Hi, <strong>{{username}}</strong></p><p>Your subscription on <strong>{{plan}}</strong> plan is about to expire on <strong>{{expiry_date}}</strong>.</p><p>Please renew your subscription before the expiration date. <a href="{{link}}">{{link}}</a></p><p>Have further questions? You can start chatting with the live support team.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
            array('lang' => 'fr', 'key' => 'subscription_expired', 'name' => 'Subscription Expired Email', 'subject' => 'Your subscription has been expired', 'body' => '<p>Hi, <strong>{{username}}</strong></p><p>Your subscription on <strong>{{plan}}</strong> plan has expired on <strong>{{expiry_date}}</strong>.</p><p>Please renew your subscription. <a href="{{link}}">{{link}}</a></p><p>Have further questions? You can start chatting with the live support team.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', 'status' => '1'),
        );

        DB::table('mail_templates')->insert($mail_templates);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_templates');
    }
};
