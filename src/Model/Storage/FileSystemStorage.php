<?php

namespace Panosmits\Basekit\Model\Storage;

class FileSystemStorage implements StorageInterface
{
    public const STORAGE_NAME = 'FileSystem';

    public static function make(): FileSystemStorage
    {
        return new FileSystemStorage();
    }

    public function save($file): string
    {
        // TODO: Implement save() method.
        return 'Saving in FileSystemStorage';
    }
}