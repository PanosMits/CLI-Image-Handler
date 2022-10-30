<?php

namespace Panosmits\Basekit\Model\Storage;

enum StorageEnum: string
{
    case DEFAULT_STORAGE = 'FileSystem';
    //case S3 = 'S3';
    //case FTP = 'FTP';

    public static function valueExists(string $value): bool
    {
        return !empty(array_filter(StorageEnum::cases(), fn($case) => strtolower($case->value) === strtolower($value)));
    }
}