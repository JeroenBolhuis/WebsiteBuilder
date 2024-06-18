<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_color',
        'secondary_color',
        'favicon',
        'image',
        'use_logo',
    ];

    public function image()
    {
        return $this->belongsTo(Media::class);
    }
}
