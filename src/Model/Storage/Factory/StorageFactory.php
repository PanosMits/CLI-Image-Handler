<?php

namespace Panosmits\Basekit\Model\Storage\Factory;

use Panosmits\Basekit\Model\Storage\FileSystemStorage;
use Panosmits\Basekit\Model\Storage\StorageEnum;
use Panosmits\Basekit\Model\Storage\StorageInterface;

class StorageFactory
{
    public static function createFromInput(string $storage): StorageInterface
    {
        $lowerCaseStorage = strtolower($storage);
        if ($lowerCaseStorage === strtolower(StorageEnum::DEFAULT_STORAGE->value)) return FileSystemStorage::make();

        // As default - Normally, the program will exit before reaching here if the storage provided is not supported.
        // Adding the following line to stop IDE from complaining.
        return FileSystemStorage::make();
    }
}