<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Validator;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('lang')) {

            $language = Language::where('code', $request->lang)->firstOrFail();

            $mailTemplates = MailTemplate::where('lang', $language->code)->with('language')->get();

            $current_language = $language->code;

            return view('admin.mailtemplates.index', compact('mailTemplates', 'current_language'));
        } else {
            return redirect(url()->current() . '?lang=' . env('DEFAULT_LANGUAGE'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param MailTemplate $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MailTemplate $mailTemplate)
    {
        $global_shortcodes = [
            'website_name' => ___('Your Website Name'),
            'username' => ___('Username'),
            'user_fullname' => ___("User's Full Name"),
        ];

        $shortcodes = match ($mailTemplate->key) {
            'password_reset' => [
                'link' => ___('Password Reset Link'),
                'expiry_time' => ___('Expiry Time'),
            ],
            'email_verification' => [
                'link' => ___('Email Verification Link'),
            ],
            'subscription_about_expired', 'subscription_expired' => [
                'plan' => ___('Plan Name'),
                'expiry_date' => ___('Expiry Date'),
                'link' => ___('Subscription Page Link'),
            ],
            default => [],
        };

        $mailTemplate->shortcodes = array_merge($global_shortcodes, $shortcodes);

        return view('admin.mailtemplates.edit', compact('mailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param MailTemplate $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailTemplate $mailTemplate)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        /* Check if mail template can be disabled */
        if (!$mailTemplate->alwaysOn()) {
            $request->status = $request->get('status');
        } else {
            $request->status = 1;
        }

        $response = $mailTemplate->update([
            'status' => $request->status,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);
        if ($response) {
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }
}
