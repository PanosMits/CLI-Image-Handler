<?php

namespace Panosmits\Basekit\Service;

use Exception;
use Panosmits\Basekit\Logger\MyLogger;
use Panosmits\Basekit\Model\Storage\FileSystemStorage;
use Panosmits\Basekit\Model\Storage\StorageEnum;
use Panosmits\Basekit\Model\Storage\StorageFactory;
use Panosmits\Basekit\Model\Storage\StorageInterface;
use Panosmits\Basekit\Repository\FileRepository;
use Throwable;

class FileService
{
    private FileRepository $fileRepository;
    private MyLogger $myLogger;

    public function __construct(FileRepository $fileRepository, MyLogger $logger)
    {
        $this->fileRepository = $fileRepository;
        $this->myLogger = $logger;
    }

    /**
     * Saves a file
     * @throws Exception
     */
    public function save(string $filePath, string $storageFromInput): string
    {
        try {
            $storage = StorageFactory::createFromInput($storageFromInput);
            // TODO: Image::createFromInput($filePath);
            // TODO: Perform file validation

            $this->myLogger->logger->info('File: $file validated successfully', [FileService::class]);
            return $this->fileRepository->save('My File', $storage);
        } catch (Throwable $exception) {
            // Exception can either be from FileRepository or from File validation failure. Maybe add ->getPrevious() ?
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}