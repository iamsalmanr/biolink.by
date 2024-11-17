<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOption extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'object',
    ];

    /**
     * Relationships
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get PostOption by key
     */
    public static function getPostOption($postId, $key, $default = null)
    {
        $option = PostOption::where([['post_id', $postId], ['key', $key]])->first();
        if ($option) {
            return $option->value;
        }
        return (!empty($default)) ? $default : false;
    }

    /**
     * Update PostOption from table.
     */
    public static function updatePostOption($postId, $key, $value)
    {
        $option = PostOption::where([['post_id', $postId], ['key', $key]])->first();
        if ($option) {
            $option->value = $value;
            return $option->save();
        } else {
            $option = new PostOption();
            $option->post_id = $postId;
            $option->key = $key;
            $option->value = $value;
            return $option->save();
        }
    }

}
