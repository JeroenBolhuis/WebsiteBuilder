<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'post_media')
            ->withPivot('id', 'order')
            ->withTimestamps()
            ->orderBy('order');
    }

    public function getDescriptionAttribute($old_value)
    {
        return str_replace(['<script>', '</script>'], '', $old_value);
    }
}
