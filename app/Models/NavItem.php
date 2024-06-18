<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'page_id', 'order', 'url'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function children()
    {
        return $this->hasMany(NavItem::class, 'parent_id');
    }
}
