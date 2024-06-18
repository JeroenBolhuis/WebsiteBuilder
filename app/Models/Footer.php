<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'content',
        'enabled',
    ];

    public function image()
    {
        return $this->belongsTo(Media::class);
    }
}
