<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $token
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(url('/') . route('password.reset', ['token' => $this->token, 'email' => $this->user->getEmailForPasswordReset()], false));

        $expire = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        $short_codes = [
            '{{website_name}}' => config('settings.site_title'),
            '{{username}}' => $this->user->username,
            '{{user_fullname}}' => $this->user->name,
            '{{link}}' => $url,
            '{{expiry_time}}' => $expire,
        ];

        $this->subject(str_replace(array_keys($short_codes), array_values($short_codes), email_template('password_reset')->subject));

        return $this->markdown('emails.default', [
            'body' => email_template('password_reset')->body,
            'short_codes' => $short_codes,
        ]);
    }
}
