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

class SaveCommand extends Command
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
    protected static $defaultDescription = 'Save the file';

    public function __construct(FileService $fileService, MyLogger $logger)
    {
        parent::__construct('save');
        $this->fileService = $fileService;
        $this->myLogger = $logger;
    }

    protected function configure(): void
    {
        $this->addArgument(
            'image_path',
            InputArgument::REQUIRED,
            'The path of the image you want to store.'
        )->addOption(
            'storage',
            null,
            InputOption::VALUE_OPTIONAL,
            'The storage you want to store the image. Defaults to ' . StorageEnum::DEFAULT_STORAGE->value,
            StorageEnum::DEFAULT_STORAGE->value
        );
    }

    /**
     * Execute the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filepath = $input->getArgument('image_path');
        $storage = $input->getOption('storage');
        if (!StorageEnum::valueExists($storage)) {
            CustomStyler::createFromIO($input, $output)->failure('Storage provided is not supported.');
            return Command::FAILURE;
        }

        $this->myLogger->logger->info(
            'Initiating process of saving image from ' . $filepath . ' to ' . $storage,
            [SaveCommand::class]
        );

        try {
            $imageUuid = $this->fileService->save($filepath, $storage);
            $this->myLogger->logger->info('File: $file successfully saved.', [SaveCommand::class]);
            CustomStyler::createFromIO($input, $output)->successful('Image successfully saved with id: ' . $imageUuid);
            return Command::SUCCESS;
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            $this->myLogger->logger->error(
                'Error occurred while saving file: $file. Message: ' . $errorMessage,
                [SaveCommand::class]
            );
            CustomStyler::createFromIO($input, $output)->failure('File could not be saved. Reason: ' . $errorMessage);
            return Command::FAILURE;
        }
    }
}