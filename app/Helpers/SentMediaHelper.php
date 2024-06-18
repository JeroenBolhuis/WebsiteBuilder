<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class SentMediaHelper
{
    public static function getSentMedia($postSlug)
    {
        if ($postSlug == null) {
            return;
        }

        $media = Storage::files('public/posts/' . $postSlug);

        return $media;
    }
}
