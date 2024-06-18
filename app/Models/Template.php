<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pages()
    {
        return $this->belongsToMany(Page::class)->withPivot('id', 'order', 'data');
    }

    public function media()
    {
        return $this->belongsToMany(Media::class)->withPivot('id');
    }

    public function category()
    {
        return $this->belongsTo(TemplateCategory::class);
    }

    public function getInputNamesAttribute()
    {
        $template_classname = 'App\View\Components\Templates\\' . $this->name . '\Admin';
        $template_class = new $template_classname();
        return $template_class->input_names;
    }
}
