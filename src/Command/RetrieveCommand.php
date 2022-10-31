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

class RetrieveCommand extends Command
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
    protected static $defaultDescription = 'Retrieve an image';

    public function __construct(FileService $fileService, MyLogger $logger)
    {
        parent::__construct('retrieve');
        $this->fileService = $fileService;
        $this->myLogger = $logger;
    }

    protected function configure(): void
    {
        $this->addArgument(
            'image_id',
            InputArgument::REQUIRED,
            'The ID of the image you want to retrieve.'
        )->addOption(
            'fromStorage',
            null,
            InputOption::VALUE_OPTIONAL,
            'The storage you want to retrieve the image from. Defaults to ' . StorageEnum::DEFAULT_STORAGE->value,
            StorageEnum::DEFAULT_STORAGE->value
        );
    }

    /**
     * Execute the retrieve command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $imageId = $input->getArgument('image_id');
        $fromStorage = $input->getOption('fromStorage');
        $this->myLogger->logger->info(
            'Initiating process of retrieving image with ID:  ' . $imageId . ' from ' . $fromStorage,
            [SaveCommand::class]
        );

        if (!StorageEnum::valueExists($fromStorage)) {
            CustomStyler::createFromIO($input, $output)->failure('Storage provided is not supported.');
            return Command::FAILURE;
        }

        try {
            $file = $this->fileService->retrieve($imageId, $fromStorage);
            CustomStyler::createFromIO($input, $output)->successful('Image with ID: ' . $imageId . ' successfully retrieved: ' . $file);
            return Command::SUCCESS;
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            CustomStyler::createFromIO($input, $output)->failure('Image could not be retrieved. Reason: ' . $errorMessage);
            return Command::FAILURE;
        }
    }
}
