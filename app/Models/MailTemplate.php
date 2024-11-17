<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    public $timestamps = false;

    private const ALWAYS_ON_TEMPLATES = [
        'password_reset',
        'email_verification',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lang',
        'subject',
        'body',
        'status',
    ];

    public function alwaysOn()
    {
        return in_array($this->key, self::ALWAYS_ON_TEMPLATES);
    }

    /**
     * Relationships
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}
