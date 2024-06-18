<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PreventSpamPost extends Model
{
    private static $cooldown = 60;

    protected $guarded = [];

    public static function isSpam(string $ipAddress): bool
    {
        foreach (self::where('created_at', '>=', now()->subSeconds(PreventSpamPost::$cooldown))->get() as $record) {
            if (Hash::check($ipAddress, $record->ip_address)) {
                return true;
            }
        }
        return false;
    }
}
