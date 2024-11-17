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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('user_type', ['user', 'admin'])->default('user');
            $table->string('name');
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('avatar');
            $table->string('password');
            $table->text('address');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('google2fa_status')->default(false);
            $table->text('google2fa_secret')->nullable();
            $table->string('oauth_id')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->string('plan_id',20)->index('plan_id');
            $table->text('plan_settings');
            $table->string('plan_interval',20)->default('LIFETIME')->nullable();
            $table->dateTime('plan_expiration_date')->nullable();
            $table->boolean('plan_trial_done')->default(false);
            $table->boolean('plan_about_to_expire_reminder')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('is_viewed')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
