<?php

namespace Panosmits\Basekit\Command;

use Exception;
use Panosmits\Basekit\Logger\MyLogger;
use Panosmits\Basekit\Model\CustomStyler;
use Panosmits\Basekit\Model\Storage\StorageEnum;
use Panosmits\Basekit\Service\FileService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command
{
    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * @var MyLogger
     */
    private MyLogger $myLogger;

    /**
     * The command description
     * @var string
     */
    protected static $defaultDescription = 'Delete the file';

        public function __construct(FileService $fileService, MyLogger $logger)
        {
            parent::__construct('delete');
            $this->fileService = $fileService;
            $this->myLogger = $logger;
        }

    protected function configure(): void
    {
        $this->addArgument(
            'image_id',
            InputArgument::REQUIRED,
            'The ID of the image you want to delete.'
        )->addOption(
            'fromStorage',
            null,
            InputOption::VALUE_OPTIONAL,
            'The storage you want to delete the image from. Defaults to ' . StorageEnum::DEFAULT_STORAGE->value,
            StorageEnum::DEFAULT_STORAGE->value
        );
    }

    /**
     * Execute the delete command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $imageId = $input->getArgument('image_id');
        $fromStorage = $input->getOption('fromStorage');
        $this->myLogger->logger->info(
            'Initiating process of deleting image with ID:  ' . $imageId . ' from ' . $fromStorage,
            [SaveCommand::class]
        );

        if (!StorageEnum::valueExists($fromStorage)) {
            CustomStyler::createFromIO($input, $output)->failure('Storage provided is not supported.');
            return Command::FAILURE;
        }

        try {
            $this->fileService->delete($imageId, $fromStorage);
            CustomStyler::createFromIO($input, $output)->successful('Image with ID: ' . $imageId . ' successfully deleted.');
            return Command::SUCCESS;
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            CustomStyler::createFromIO($input, $output)->failure('Image could not be deleted. Reason: ' . $errorMessage);
            return Command::FAILURE;
        }
    }
}