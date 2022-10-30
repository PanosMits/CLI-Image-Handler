<?php

namespace Panosmits\Basekit\Repository;

use Panosmits\Basekit\Logger\MyLogger;
use Panosmits\Basekit\Model\Storage\StorageInterface;

class FileRepository
{
    private MyLogger $myLogger;

    public function __construct(MyLogger $myLogger)
    {
        $this->myLogger = $myLogger;
    }

    public function save(string $filePath, StorageInterface $storage): void
    {
        $this->myLogger->logger->info('Attempting to save file: ' . $filePath . ' in ' . $storage::STORAGE_NAME, [FileRepository::class]);
        $storage->save($filePath);
    }
}