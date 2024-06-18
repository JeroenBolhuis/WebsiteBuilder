<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getUserAttribute()
    {
        $user = User::find($this->user_id);
        if (!$user) {
            $user = new User();
            $user->name = 'Onbekend';
        }

        return $user;
    }
}
