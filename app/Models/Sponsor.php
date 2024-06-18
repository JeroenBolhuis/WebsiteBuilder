<?php

namespace App\Models;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->join('pages', 'sponsors.page_id', '=', 'pages.id')
            ->where('pages.isActive', true)
            ->select('sponsors.*', 'pages.slug as page_slug');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function image()
    {
        return $this->belongsTo(Media::class);
    }

    public function getImageAttrAttribute()
    {
        return MediaHelper::getMedia($this->image_id);
    }
}
