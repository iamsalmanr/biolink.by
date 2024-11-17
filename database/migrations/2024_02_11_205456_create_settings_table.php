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
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->text('value')->nullable();
        });

        $settings = array(
            array('key' => 'site_title','value' => '"Quick BioLink"'),
            array('key' => 'enable_user_registration','value' => '"1"'),
            array('key' => 'enable_email_verification','value' => '"1"'),
            array('key' => 'enable_force_ssl','value' => '"0"'),
            array('key' => 'include_language_code','value' => '"1"'),
            array('key' => 'enable_faqs','value' => '"1"'),
            array('key' => 'terms_of_service_link','value' => NULL),
            array('key' => 'enable_contact_page','value' => '"1"'),
            array('key' => 'contact_email','value' => '"test@gmail.com"'),
            array('key' => 'enable_cookie_consent_box','value' => '"1"'),
            array('key' => 'cookie_policy_link','value' => NULL),
            array('key' => 'date_format','value' => '"d F, Y"'),
            array('key' => 'time_format','value' => '"g:i A"'),
            array('key' => 'timezone','value' => '"Asia\\/Kolkata"'),
            array('key' => 'disable_landing_page','value' => '"0"'),
            array('key' => 'media','value' => '{"dark_logo":"dark_logo.png","light_logo":"light_logo.png","favicon":"favicon.png","social_image":"social_image.jpeg","admin_logo":"admin_logo.png"}'),
            array('key' => 'colors','value' => '{"primary_color":"#d90a2c"}'),
            array('key' => 'smtp','value' => '{"status":"0","from_email":null,"from_name":null,"mailer":"log","host":null,"port":null,"username":null,"password":null,"encryption":"tls"}'),
            array('key' => 'currency','value' => '{"code":"USD","symbol":"$","position":"1"}'),
            array('key' => 'invoice_billing','value' => '{"invoice_number_prefix":"INV-","name":"test","email":"test@gmail.com","phone":"test","address":"test","city":"test","state":"test","zipcode":"test","country":"Brazil","tax_type":"VAT","tax_id":"1234"}'),
            array('key' => 'blog','value' => '{"status":"1","show_on_home":"1","commenting":"1","page_limit":"8"}'),
            array('key' => 'testimonials','value' => '{"status":"1","show_on_home":"1","show_on_blog":"1"}'),
            array('key' => 'google_recaptcha','value' => '{"status":"0","site_key":null,"secret_key":null}'),
            array('key' => 'google_analytics','value' => '{"status":"0","measurement_id":null}'),
            array('key' => 'tawk_to','value' => '{"status":"0","chat_link":null}'),
            array('key' => 'facebook_login','value' => '{"status":"0","app_id":null,"app_secret":null}'),
            array('key' => 'google_login','value' => '{"status":"0","client_id":null,"client_secret":null}'),
            array('key' => 'social_links','value' => '{"facebook":"http:\\/\\/facebook.com","twitter":null,"instagram":null,"linkedin":null,"pinterest":"http:\\/\\/pinterest.com","youtube":null}'),
            array('key' => 'custom_css','value' => '"\\/\\/ Custom CSS here"'),
            array('key' => 'free_membership_plan','value' => '{"id":"free","status":"1","name":"Free","description":null,"translations":"","settings":{"biolink_limit":"1","biopage_limit":"1","hide_branding":"0","advertisements":"1","custom_features":{}}}'),
            array('key' => 'trial_membership_plan','value' => '{"id":"trial","status":"1","name":"Trial","description":null,"translations":"","settings":{"biolink_limit":"1","biopage_limit":"1","hide_branding":"0","advertisements":"1","custom_features":{}},"days":"7"}'),
        );

        DB::table('settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
