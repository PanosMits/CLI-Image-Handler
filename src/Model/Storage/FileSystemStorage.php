<?php

namespace Panosmits\Basekit\Model\Storage;

use Exception;
use Ramsey\Uuid\Uuid;
use Throwable;

class FileSystemStorage implements StorageInterface
{
    private string $name;

    public function __construct(string $name = 'FileSystem')
    {
        $this->name = $name;
    }

    public static function make(): FileSystemStorage
    {
        return new FileSystemStorage();
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws Exception
     */
    public function save(string $filePath): string
    {
        $imageUuid = Uuid::uuid4()->toString();
        $destinationPath = __DIR__.getenv('LOCAL_DIRECTORY');
        try {
            if (!is_dir($destinationPath)) {
                if (!mkdir($destinationPath, 0777, true)) {
                    throw new Exception('Unable to create storage directory.');
                }
            }
            file_put_contents($destinationPath . $imageUuid . '.png', file_get_contents($filePath));
            return $imageUuid;
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete(string $imageId): void
    {
        // TODO: Implement delete() method.
    }
}