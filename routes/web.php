<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Install routes
Route::prefix('install')->group(function () {
    Route::middleware('notInstalled')->group(function () {
        Route::get('/', 'InstallController@index')->name('install');
        Route::get('/requirements', 'InstallController@requirements')->name('install.requirements');
        Route::get('/permissions', 'InstallController@permissions')->name('install.permissions');
        Route::get('/database', 'InstallController@database')->name('install.database');
        Route::post('/database', 'InstallController@updateEnv');
        Route::get('/admin', 'InstallController@admin')->name('install.admin');
        Route::post('/admin', 'InstallController@createAdmin');
    });

    Route::get('/complete', 'InstallController@complete')->name('install.complete');
});

/* Routs With Laravel Localization */
if (!config('settings.include_language_code')) {
    $middlewares = [
        'middleware' => ['installed', 'checkUserIsBanned', 'quickcms.localize'],
    ];
} else {
    $middlewares = [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['installed', 'checkUserIsBanned', 'localize', 'localizationRedirect', 'localeSessionRedirect'],
    ];
}

Route::group($middlewares, function () {

    /* AUTH ROUTES */
    require __DIR__ . '/auth.php';

    /* FRONTEND ROUTES */
    Route::controller('HomeController')->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('faqs', 'faqs')->name('faqs');
        Route::get('contact-us', 'contact')->name('contact');
        Route::post('contact-us', 'contactSend')->name('contact');
        Route::get('pricing', 'pricing')->name('pricing');
        Route::get('page/{slug}', 'page')->name('page');

        if (!config('settings.include_language_code')) {
            Route::get('{lang}', 'localize')->where('lang', '^[a-z]{2}$')->name('localize');
        }
    });

    Route::controller('BlogController')->group(function () {
        Route::get('/blog', 'index')->name('blog.index');
        Route::get('blog/categories/{slug}', 'category')->name('blog.category');
        Route::get('blog/tags/{slug}', 'tag')->name('blog.tag');
        Route::get('blog/{slug}', 'single');
        Route::post('blog/{slug}', 'comment')->name('blog.article');
    });

    /* FRONTEND LOGIN REQUIRED */
    Route::group(['namespace' => 'User', 'middleware' => ['auth', 'verified', 'verify.2fa']], function () {

        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::controller('PostController')->group(function () {
            Route::post('biolinks/reorder/{post}', 'reorder')->name('biolinks.reorder');
            Route::post('biolinks/addheader/{post}', 'addheader')->name('biolinks.addheader');
            Route::post('biolinks/addlink/{post}', 'addlink')->name('biolinks.addlink');
            Route::post('biolinks/addsocial/{post}', 'addsocial')->name('biolinks.addsocial');
            Route::post('biolinks/editHeader/{post}', 'editHeader')->name('biolinks.editHeader');
            Route::post('biolinks/editLink/{post}', 'editLink')->name('biolinks.editLink');
            Route::post('biolinks/editSocial/{post}', 'editSocial')->name('biolinks.editSocial');
            Route::post('biolinks/deleteLink/{post}', 'deleteLink')->name('biolinks.deleteLink');
        });
        Route::resource('biolinks', 'PostController');

        Route::controller('SettingsController')->group(function () {
            Route::get('settings', 'index')->name('settings');
            Route::post('settings/edit-profile', 'editProfile')->name('editProfile');

            Route::post('settings/change-password', 'changePassword')->name('changePassword')->middleware('demo');

            Route::post('2fa/enable', 'towFAEnable')->name('2fa.enable')->middleware('demo');
            Route::post('2fa/disabled', 'towFADisable')->name('2fa.disable');
        });


        Route::get('transactions', 'TransactionController@index')->name('transactions');
        Route::get('invoice/{transaction}', 'TransactionController@invoice')->name('invoice');

        Route::get('subscription', 'SubscribeController@mySubscription')->name('subscription');

        Route::controller('CheckoutController')->group(function () {
            Route::get('checkout', 'index')->name('checkout.index');
            Route::post('checkout', 'index');
        });

        Route::get('ipn/paypal', 'PaymentMethods\PaypalController@ipn')->name('ipn.paypal');
        Route::get('ipn/stripe', 'PaymentMethods\StripeController@ipn')->name('ipn.stripe');
        Route::get('ipn/mollie', 'PaymentMethods\MollieController@ipn')->name('ipn.mollie');
        Route::post('ipn/razorpay', 'PaymentMethods\RazorpayController@ipn')->name('ipn.razorpay');

    });

    /* ADMIN ROUTES */
    Route::name('admin.')->prefix(admin_url())->namespace('Admin')->middleware(['admin', 'demo', 'verify.2fa'])->group(function () {

        Route::redirect('/', 'admin/dashboard');

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/posts', 'PostController@index')->name('posts.index');
        Route::post('posts.delete', 'PostController@delete')->name('posts.delete');

        Route::controller('NotificationController')->group(function () {
            Route::get('/notifications', 'index')->name('notifications.index');
            Route::get('notifications/view/{id}', 'view')->name('notifications.view');
            Route::get('notifications/markasread', 'markAsRead')->name('notifications.markasread');
            Route::delete('notifications/deleteallread', 'deleteAllRead')->name('notifications.deleteallread');
        });

        Route::controller('UserController')->group(function () {
            Route::post('users/delete', 'delete')->name('users.delete');
            Route::delete('users/{user}/edit/delete/avatar', 'deleteAvatar')->name('users.deleteAvatar');
            Route::post('users/{user}/edit/sentmail', 'sendMail')->name('users.sendmail');
            Route::get('users/{user}/edit/logs', 'logs')->name('users.logs');
            Route::get('users/logs/{ip}', 'logsByIp')->name('users.logsbyip');
            Route::get('users/{user}/edit/password', 'password')->name('users.password');
            Route::post('users/{user}/edit/password', 'updatePassword')->name('users.password');
        });
        Route::resource('users', 'UserController');

        Route::controller('TemplateController')->group(function () {
            Route::get('/templates', 'index')->name('templates.index');
            Route::post('/templates', 'templatesActive')->name('templates.active');
        });

        Route::resource('taxes', 'TaxController');
        Route::post('taxes.delete', 'TaxController@delete')->name('taxes.delete');

        Route::resource('transactions', 'TransactionController');
        Route::get('transactions/invoice/{id}', 'TransactionController@invoice')->name('transactions.invoice');
        Route::post('transactions.delete', 'TransactionController@delete')->name('transactions.delete');

        Route::resource('plans', 'PlanController');
        Route::post('plans.delete', 'PlanController@delete')->name('plans.delete');
        Route::post('plans.reorder', 'PlanController@reorder')->name('plans.reorder');

        Route::resource('planoption', 'PlanOptionController');
        Route::post('planoption.delete', 'PlanOptionController@delete')->name('planoption.delete');
        Route::post('planoption.reorder', 'PlanOptionController@reorder')->name('planoption.reorder');

        Route::resource('coupons', 'CouponController');
        Route::post('coupons.delete', 'CouponController@delete')->name('coupons.delete');

        Route::resource('testimonials', 'TestimonialController');
        Route::post('testimonials.delete', 'TestimonialController@delete')->name('testimonials.delete');

        Route::resource('advertisements', 'AdsController');

        Route::resource('pages', 'PageController');

        Route::resource('faqs', 'FaqController');

        Route::controller('PaymentGatewayController')->group(function () {
            Route::get('/payment-gateways', 'index')->name('gateways.index');
            Route::get('payment-gateways/{gateway}/edit', 'edit')->name('gateways.edit');
            Route::post('payment-gateways/{gateway}', 'update')->name('gateways.update');
        });

        Route::controller('EmailTemplateController')->group(function () {
            Route::get('/email-templates', 'index')->name('mailtemplates.index');
            Route::get('email-templates/{mailTemplate}/edit', 'edit')->name('mailtemplates.edit');
            Route::post('email-templates/{mailTemplate}', 'update')->name('mailtemplates.update');
        });

        Route::controller('LanguageController')->group(function () {
            Route::post('languages/reorder', 'reorder')->name('languages.reorder');
            Route::get('languages/translate/{code}', 'translate')->name('languages.translates');
            Route::post('languages/{id}/update', 'translateUpdate')->name('languages.translates.update');
        });
        Route::resource('languages', 'LanguageController');

        Route::get('settings', 'SettingsController@index')->name('settings.index');
        Route::post('settings', 'SettingsController@update')->name('settings.update');

        Route::resource('navigation/navbarMenu', 'NavbarMenuController');
        Route::post('navigation/navbarMenu/order', 'NavbarMenuController@order')->name('navbarMenu.order');

        Route::resource('navigation/footerMenu', 'FooterMenuController');
        Route::post('navigation/footerMenu/order', 'FooterMenuController@order')->name('footerMenu.order');

        Route::resource('blogs', 'BlogController');
        Route::post('blog/delete', 'BlogController@delete')->name('blogs.delete');
        Route::get('blog/get-categories/{lang}', 'BlogController@getCategories');

        Route::resource('blog/categories', 'BlogCategoryController');
        Route::post('blog/categories/delete', 'BlogCategoryController@delete')->name('categories.delete');

        Route::get('blog/comments', 'BlogCommentController@index')->name('comments.index');
        Route::post('blog/comments/delete', 'BlogCommentController@delete')->name('comments.delete');
        Route::post('blog/comments/{id}/approve', 'BlogCommentController@approve')->name('comments.approve');
    });
});

/* POST PAGE VIEW */
Route::get('{slug}', 'User\PostController@publicView')->name('publicView');
