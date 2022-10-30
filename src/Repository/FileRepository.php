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

    public function save($file, StorageInterface $storage): string
    {
        $this->myLogger->logger->info('Attempting to save file: ' . $file . ' in ' . $storage::STORAGE_NAME, [FileRepository::class]);
        return $storage->save($file);
    }
}