<?php

namespace App\Models;

use App\Mails\ResetPassword;
use App\Mails\VerifyEmail;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'status',
        'user_type',
        'name',
        'firstname',
        'lastname',
        'username',
        'email',
        'address',
        'avatar',
        'password',
        'google2fa_status',
        'google2fa_secret',
        'oauth_id',
        'oauth_provider',
        'plan_id',
        'plan_settings',
        'plan_interval',
        'plan_expiration_date',
        'plan_trial_done',
        'plan_about_to_expire_reminder',
        'is_viewed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'address' => 'object',
        'email_verified_at' => 'datetime',
        'plan_settings' => 'object',
        'plan_expiration_date' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'username' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Send Password Reset Notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->sendMail(new ResetPassword($this, $token));
    }

    /**
     * Send Email Verification Notification.
     */
    public function sendEmailVerificationNotification()
    {
        if (config('settings.enable_email_verification')) {
            $this->sendMail(new VerifyEmail($this));
        }
    }

    /**
     * Send email to the user
     *
     * @param Mailable $mailable
     * @return bool|string
     */
    public function sendMail(Mailable $mailable)
    {
        try {
            Mail::to($this->email)->send($mailable);
        } catch(\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Get user's plan
     *
     * @return mixed
     */
    public function plan()
    {
        if(is_numeric($this->plan_id)){
            if($plan = Plan::find($this->plan_id)){
                return $plan;
            } else {
                return config('settings.free_membership_plan');
            }
        } else if ($this->plan_id == 'trial'){
            return config('settings.trial_membership_plan');
        } else {
            return config('settings.free_membership_plan');
        }
    }

    /**
     * Relationships
     */

    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
