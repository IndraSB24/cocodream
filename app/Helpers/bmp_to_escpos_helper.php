<?php

function imageToEscpos($imagePath) {
    $img = imagecreatefrombmp($imagePath);
    if (!$img) {
        return null;
    }

    $width = imagesx($img);
    $height = imagesy($img);

    // Initialize ESC/POS command for image printing
    $escposData = "\x1D\x76\x30\x00" . chr($width % 256) . chr($width / 256) . chr($height % 256) . chr($height / 256);

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $pixel = imagecolorat($img, $x, $y);
            $gray = (imagecolorsforindex($img, $pixel)['red'] + imagecolorsforindex($img, $pixel)['green'] + imagecolorsforindex($img, $pixel)['blue']) / 3;
            $escposData .= $gray < 128 ? "\x00" : "\x01";
        }
    }

    return $escposData;
}
