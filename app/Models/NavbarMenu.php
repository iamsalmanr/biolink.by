<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarMenu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "navbar_menu";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lang',
        'name',
        'link',
        'parent_id',
        'type',
        'order',
    ];

    /**
     * Relationships
     */

    public function children()
    {
        return $this->hasMany(NavbarMenu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(NavbarMenu::class, 'parent_id');
    }
}
