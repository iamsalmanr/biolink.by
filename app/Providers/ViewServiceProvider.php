<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Language;
use App\Models\NavbarMenu;
use App\Models\Notification;
use App\Models\Settings;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\View\ViewServiceProvider as ConcreteViewServiceProvider;

class ViewServiceProvider extends ConcreteViewServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $activeTheme = active_theme();

        if (env('APP_INSTALLED')) {

            view()->composer('*', function ($view) {
                $view->with([
                    'settings' => array_to_object(Settings::pluck('value', 'key')->all()),
                    'activeTheme' => active_theme(),
                    'activeThemeAssets' => active_theme(true)
                ]);
            });

            if (is_admin_url()) {

                /* Admin pages */
                view()->composer('*', function ($view) {
                    $admin_languages = Language::where('active', 1)->orderBy('position')->get();
                    $view->with('admin_languages', $admin_languages);
                });

                view()->composer('admin.includes.header', function ($view) {
                    $notifications = Notification::orderbyDesc('id')->limit(20)->get();
                    $totalUnreadNotifications = Notification::where('status', 0)->get()->count();
                    $view->with([
                        'notifications' => $notifications,
                        'totalUnreadNotifications' => $totalUnreadNotifications,
                    ]);
                });

                view()->composer('admin.includes.sidebar', function ($view) {
                    $totalUnviewedUsers = User::where('is_viewed', 0)->count();
                    $totalUnapprovedComments = BlogComment::where('status', 0)->count();
                    $totalUnviewedTransactions = Transaction::where('is_viewed', 0)->whereIn('status', [Transaction::STATUS_PENDING, Transaction::STATUS_PAID])->count();
                    $view->with([
                        'totalUnviewedUsers' => ($totalUnviewedUsers > 50) ? "50+" : $totalUnviewedUsers,
                        'totalUnapprovedComments' => ($totalUnapprovedComments > 50) ? "50+" : $totalUnapprovedComments,
                        'totalUnviewedTransactions' => ($totalUnviewedTransactions > 50) ? "50+" : $totalUnviewedTransactions,
                    ]);
                });

            } else {
                /* Frontend pages */

                view()->composer('*', function ($view) {
                    $languages = Language::where('active', 1)->orderBy('position', 'asc')->get();
                    $view->with('languages', $languages);
                });

                view()->composer($activeTheme . 'layouts.includes.nav-menu', function ($view) {
                    $navMenus = NavbarMenu::where('lang', get_lang())->where('type', 'header')->whereNull('parent_id')->with(['children' => function ($query) {
                        $query->orderBy('order');
                    }])->orderBy('order')->get();
                    $view->with('navMenus', $navMenus);
                });

                view()->composer($activeTheme . 'blog.sidebar', function ($view) {
                    $blogCategories = BlogCategory::where('lang', get_lang())->get();
                    $recentBlogs = Blog::where('lang', get_lang())->orderbyDesc('id')->limit(8)->get();

                    $tags = [];
                    $data = Blog::where('lang', get_lang())->select('tags')->get();
                    foreach ($data as $value) {
                        if (!empty($value->tags)) {
                            $tag = explode(',', $value->tags);
                            $tags = array_merge($tags, $tag);
                        }
                    }
                    $tags = array_unique($tags);

                    $view->with(['blogCategories' => $blogCategories, 'recentBlogs' => $recentBlogs, 'blogTags' => $tags]);
                });

                view()->composer($activeTheme . 'layouts.includes.footer', function ($view) {
                    $navMenus = NavbarMenu::where('lang', get_lang())->where('type', 'footer')->whereNull('parent_id')->with(['children' => function ($query) {
                        $query->orderBy('order');
                    }])->orderBy('order')->get();
                    $view->with('navMenus', $navMenus);
                });

            }

        }
    }
}
