<?php

namespace Panosmits\Basekit\Service;

use Exception;
use Panosmits\Basekit\Logger\MyLogger;
use Panosmits\Basekit\Model\Storage\Factory\StorageFactory;
use Panosmits\Basekit\Repository\FileRepository;
use Panosmits\Basekit\Validators\ImageValidator;
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
     * @param string $filepath The URL of the image
     * @param string $storageFromInput The storage option provided by the user
     * @return string The UUID assigned to the image after a successful save
     * @throws Exception
     */
    public function save(string $filepath, string $storageFromInput): string
    {
        try {
            ImageValidator::imageValidator($filepath);
            $storage = StorageFactory::createFromInput($storageFromInput);
            $this->myLogger->logger->info('File: $file validated successfully', [FileService::class]);
            return $this->fileRepository->save($filepath, $storage);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param string $imageId The ID of the image we are trying to delete
     * @param string $fromStorage The storage we want to delete the image from
     * @return void
     * @throws Exception
     */
    public function delete(string $imageId, string $fromStorage): void
    {
        try {
            $this->fileRepository->delete($imageId, StorageFactory::createFromInput($fromStorage));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param string $imageId The ID of the image we are trying to retrieve
     * @param string $fromStorage The storage we want to retrieve the image from
     * @return string
     * @throws Exception
     */
    public function retrieve(string $imageId, string $fromStorage): string
    {
        try {
            return $this->fileRepository->retrieve($imageId, StorageFactory::createFromInput($fromStorage));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}