<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lang',
        'user_id',
        'category_id',
        'title',
        'slug',
        'image',
        'content',
        'short_description',
        'tags',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Relationships
     */
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'article_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}
