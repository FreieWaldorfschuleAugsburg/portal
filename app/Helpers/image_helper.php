<?php


namespace App\Helpers;

use CodeIgniter\HTTP\IncomingRequest;
use Config\Services;
use Imagick;

/**
 * @throws \ImagickException
 */
function createGradient(string $color1, string $color2): Imagick
{
    $gradient = new Imagick();
    $gradient->newPseudoImage('1000', '1000', "gradient:$color1-$color2");
    $gradient->rotateImage('red', -30);

    $width = 250;
    $height = 280;
    $x = $gradient->getImageWidth() / 2 - $width;
    $y = $gradient->getImageHeight() / 2 - $height;

    $gradient->cropImage($width, $height, $x, $y);
    $gradient->setImageFormat('png');
    return $gradient;

}


function addImage(Imagick $gradient, Imagick $image)
{
    $image->scaleImage(256, 256);
    $gradient->compositeImage($image, IMAGICK::COMPOSITE_VIVIDLIGHT, 47, 96,);

    return $gradient;
}


/**
 * @throws \ImagickException
 */
function cropImageToCenter(Imagick $imagick, $width, $height)
{
    $imageWidth = $imagick->getImageWidth();
    $imageHeight = $imagick->getImageHeight();

    $x = ($imageWidth / 2) - $width;
    $y = ($imageHeight / 2) - $height;
    $imagick->cropImage($width, $height, $x, $y);
    return $imagick;


}

function createEntryImage(string $filePath): void
{
    $imageService = Services::image();

    $imageService->withFile($filePath)
        ->fit(512, 512)
        ->convert(IMAGETYPE_PNG)
        ->save($filePath);


}


