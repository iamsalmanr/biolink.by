<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Validator;
use App;
use Session;

class HomeController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display the home page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if(config('settings.disable_landing_page')){
            return redirect()->route('login');
        }

        $testimonials = Testimonial::limit(10)->get();
        $blogArticles = Blog::where('lang', get_lang())->limit(4)->get();
        $faqs = Faq::where('lang', get_lang())->limit(10)->get();

        return view($this->activeTheme.'.home.index')->with(compact('testimonials','faqs', 'blogArticles'));
    }

    /**
     * Display the pricing page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function pricing()
    {
        $plans = Plan::where('status', 1)->get();
        $total_monthly = $plans->sum('monthly_price');
        $total_annual = $plans->sum('annual_price');
        $total_lifetime = $plans->sum('lifetime_price');

        $free_plan = config('settings.free_membership_plan');
        $trial_plan = config('settings.trial_membership_plan');

        return view($this->activeTheme.'.home.pricing', compact(
            'plans',
            'total_monthly',
            'total_annual',
            'total_lifetime',
            'free_plan',
            'trial_plan'));
    }

    /**
     * Display the faq page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function faqs()
    {
        abort_if(!config('settings.enable_faqs'), 404);

        $faqs = Faq::where('lang', get_lang())->paginate(20);
        return view($this->activeTheme.'.home.faqs', compact('faqs'));
    }

    /**
     * Display the static page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function page($slug)
    {
        $page = Page::where([['slug', $slug], ['lang', get_lang()]])->first();
        if ($page) {
            return view($this->activeTheme.'.home.page', compact('page'));
        } else {
            abort(404);
        }
    }

    /**
     * Display the contact page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function contact()
    {
        abort_if(!config('settings.enable_contact_page'), 404);
        return view($this->activeTheme.'.home.contact');
    }

    /**
     * Handle contact requests
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function contactSend(Request $request)
    {
        abort_if(!config('settings.enable_contact_page'), 404);

        if (!config('settings.contact_email')) {
            quick_alert_error(___('Email sending is disabled.'));
            return back();
        }

        $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string'],
            ] + validate_recaptcha());

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back()->withInput();
        }

        try {
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $msg = nl2br($request->message);

            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $name) {
                $message->to(config('settings.contact_email'))
                    ->from(env('MAIL_FROM_ADDRESS'), $name)
                    ->replyTo($email)
                    ->subject($subject)
                    ->html($msg);
            });

            quick_alert_success(___('Thank you for contacting us.'));
            return back();

        } catch (\Exception$e) {
            quick_alert_error(___('Email sending failed, please try again.'));
            return back();
        }
    }

    /**
     * Change the language
     *
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function localize($code)
    {
        $language = Language::where('code', $code)->firstOrFail();
        App::setLocale($language->code);
        Session::forget('locale');
        Session::put('locale', $language->code);

        return redirect()->back();
    }
}
