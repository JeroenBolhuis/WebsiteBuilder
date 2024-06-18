<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function templates()
    {
        return $this->belongsToMany(Template::class)->withPivot('id', 'order', 'data');
    }

    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

    public function scopeSlug($query, $slug = null)
    {
        if ($slug) {
            return $query->where('slug', $slug);
        }

        return $query->where('isHomepage', true);
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public static function onlyTrashed()
    {
        return self::where('isRegularPage', true)->onlyTrashed();
    }
}
