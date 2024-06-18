<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($media) {
            $media->type = preg_match('/.mp4$/', $media->filename) ? 'video' : 'image';
        });
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class)->withPivot('id');
    }

    public function getFullpathAttribute()
    {
        return asset('storage/media/' . $this->filename);
    }

    public function getStoragePathAttribute()
    {
        return storage_path('app/public/media/' . $this->filename);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_media')
            ->withPivot('id', 'order')
            ->withTimestamps();
    }

    public function isImage()
    {
        return $this->type === 'image';
    }
}
