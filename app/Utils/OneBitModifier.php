<?php

namespace App\Utils;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class OneBitModifier implements ModifierInterface
{
    public function apply(ImageInterface $image): ImageInterface
    {
        foreach ($image as $pixel) {
            // Get brightness value of pixel (0-255)
            $brightness = $pixel->brightness();

            // Convert to Black or White based on a threshold (128)
            if ($brightness < 128) {
                $pixel->set([0, 0, 0]); // Black
            } else {
                $pixel->set([255, 255, 255]); // White
            }
        }

        return $image;
    }
}
