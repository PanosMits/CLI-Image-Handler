<?php

namespace Panosmits\Basekit\Validators;

use Exception;

class ImageValidator
{
    /**
     * @param string $filepath
     * @return bool
     * @throws Exception
     */
    public static function imageValidator(string $filepath): bool
    {
        if (!self::fileTypeIsValid($filepath)) throw new Exception('File type not supported.');
        if (!self::imageSizeIsWithinLimits($filepath)) throw new Exception('File exceeds the size limits.');
        return true;
    }

    private static function fileTypeIsValid(string $filepath): bool
    {
        $acceptedFileTypes = ['jpg', 'jpeg', 'png'];
        $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);
        return in_array($fileExtension, $acceptedFileTypes);
    }

    private static function imageSizeIsWithinLimits(string $filepath): bool
    {
        $widthLimit = 1280;
        $heightLimit = 720;
        list($width, $height) = getimagesize($filepath);
        return !(($width > $widthLimit || $height > $heightLimit));
    }
}