<?php

namespace Panosmits\Basekit\Model\Storage;

class StorageFactory
{
    // TODO: Find a way to create the correct instance without the need of If statements, just by using the $storage
    public static function createFromInput(string $storage): StorageInterface
    {
        $lowerCaseStorage = strtolower($storage);
        if ($lowerCaseStorage === strtolower(StorageEnum::DEFAULT_STORAGE->value)) return FileSystemStorage::make();
        //if ($lowerCaseStorage === strtolower(StorageEnum::S3->value)) return S3Storage::make();

        // As default - Normally, the program will exit before reaching here if the storage provided is not supported.
        // Adding the following line to stop IDE from complaining.
        return FileSystemStorage::make();
    }
}