<?php

namespace Panosmits\Basekit\Repository;

use Exception;
use Panosmits\Basekit\Logger\MyLogger;
use Panosmits\Basekit\Model\Storage\StorageInterface;
use Throwable;

class FileRepository
{
    private MyLogger $myLogger;

    public function __construct(MyLogger $myLogger)
    {
        $this->myLogger = $myLogger;
    }

    /**
     * @param string $filepath
     * @param StorageInterface $storage
     * @return string
     * @throws Exception
     */
    public function save(string $filepath, StorageInterface $storage): string
    {
        $this->myLogger->logger->info(
            'Attempting to save file: ' . $filepath . ' in ' . $storage->getName(),
            [FileRepository::class]
        );

        try {
            $imageId = $storage->save($filepath);
            $this->myLogger->logger->info('Image successfully saved with ID: ' . $imageId, [FileRepository::class]);
            return $imageId;
        } catch (Throwable $exception) {
            $this->myLogger->logger->error(
                'Error occurred while saving file: ' . $filepath . ' Message: ' . $exception->getMessage(),
                [FileRepository::class]
            );
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param string $imageId
     * @param StorageInterface $storage
     * @return void
     * @throws Exception
     */
    public function delete(string $imageId, StorageInterface $storage): void
    {
        $this->myLogger->logger->info(
            'Attempting to delete image with ID: ' . $imageId . ' from ' . $storage->getName(),
            [FileRepository::class]
        );

        try {
            $storage->delete($imageId);
            $this->myLogger->logger->info(
                'Image with ID: ' . $imageId . ' successfully deleted.',
                [FileRepository::class]
            );
        } catch (Throwable $exception) {
            $exceptionMessage = $exception->getMessage();
            $this->myLogger->logger->error(
                'Error occurred while deleting image with ID: ' . $imageId . ' Message: ' . $exceptionMessage,
                [FileRepository::class]
            );
            throw new Exception($exceptionMessage, $exception->getCode());
        }
    }

    /**
     * @param string $imageId
     * @param StorageInterface $storage
     * @return string
     * @throws Exception
     */
    public function retrieve(string $imageId, StorageInterface $storage): string
    {
        $this->myLogger->logger->info(
            'Attempting to retrieve image with ID: ' . $imageId . ' from ' . $storage->getName(),
            [FileRepository::class]
        );

        try {
            $file = $storage->retrieve($imageId);
            $this->myLogger->logger->info(
                'Image with ID: ' . $imageId . ' successfully retrieved.',
                [FileRepository::class]
            );
            return $file;
        } catch (Throwable $exception) {
            $exceptionMessage = $exception->getMessage();
            $this->myLogger->logger->error(
                'Error occurred while retrieving image with ID: ' . $imageId . ' Message: ' . $exceptionMessage,
                [FileRepository::class]
            );
            throw new Exception($exceptionMessage, $exception->getCode());
        }
    }
}