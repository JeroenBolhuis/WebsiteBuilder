<?php

namespace App\Helpers;

use App\Models\Media;

class MediaHelper
{
    public static function getMedia($mediaId)
    {        
        if (!$mediaId) {
            return self::getNoImage();
        }

        $media = Media::find($mediaId);

        if (!$media) {
            $media = self::getNoImage();
        }

        return $media;
    }

    public static function getNoImage()
    {
        $media = new Media();
        $media->filename = 'no-image.svg';
        $media->alt_text = 'Geen media gevonden';
        $media->type = 'image';
        return $media;
    }
}
