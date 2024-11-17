<?php

namespace App\Mails;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class SubscriptionAboutToExpired extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Subscription $subscription
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $short_codes = [
            '{{website_name}}' => config('settings.site_title'),
            '{{username}}' => $this->user->username,
            '{{user_fullname}}' => $this->user->name,
            '{{plan}}' => $this->user->plan()->name,
            '{{expiry_date}}' => datetime_formating($this->user->plan_expiration_date),
            '{{link}}' => route('subscription'),
        ];

        $this->subject(str_replace(array_keys($short_codes), array_values($short_codes), email_template('subscription_about_expired')->subject));

        return $this->markdown('emails.default', [
            'body' => email_template('subscription_about_expired')->body,
            'short_codes' => $short_codes
        ]);
    }
}
