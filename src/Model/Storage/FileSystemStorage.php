<?php

namespace Panosmits\Basekit\Model\Storage;

use Exception;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Ramsey\Uuid\Uuid;
use Throwable;

class FileSystemStorage implements StorageInterface
{
    public const STORAGE_NAME = 'FileSystem';

    public static function make(): FileSystemStorage
    {
        return new FileSystemStorage();
    }

    /**
     * @throws Exception
     */
    public function save(string $filePath): void
    {
        $destinationPath = __DIR__.'/../../../storage/';
        try {
            if (!is_dir($destinationPath)) {
                if (!mkdir($destinationPath, 0777, true)) {
                    throw new Exception('Unable to create storage directory.');
                }
            }
            file_put_contents($destinationPath . Uuid::uuid4() . '.png', file_get_contents($filePath));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}