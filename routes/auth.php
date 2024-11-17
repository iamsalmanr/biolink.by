<?php
/* Auth */

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('auth/{provider}', 'Auth\SocialLoginController@redirect')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialLoginController@callback')->name('social.callback');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::post('email/verify/email/change', 'Auth\VerificationController@changeEmailAddress')->name('change.email');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('2fa/verify', 'Auth\TwoFAController@showTwoFAVerifyForm')->name('2fa.verify');
    Route::post('2fa/verify', 'Auth\TwoFAController@verifyTwoFA');
});
