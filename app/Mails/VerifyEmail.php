<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
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
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->user->getKey(),
                'hash' => sha1($this->user->getEmailForVerification()),
            ]
        );

        $short_codes = [
                '{{website_name}}' => config('settings.site_title'),
                '{{username}}' => $this->user->username,
                '{{user_fullname}}' => $this->user->name,
                '{{link}}' => $verificationUrl,
            ];

        $this->subject(str_replace(array_keys($short_codes), array_values($short_codes), email_template('email_verification')->subject));

        return $this->markdown('emails.default', [
            'body' => email_template('email_verification')->body,
            'short_codes' => $short_codes,
        ]);
    }
}
