<?php

use Panosmits\Basekit\Command\SaveCommand;
use Panosmits\Basekit\Logger\MyLogger;
use Panosmits\Basekit\Repository\FileRepository;
use Panosmits\Basekit\Service\FileService;
use function DI\create;

return [
    // Commands
    'SaveCommand' => create(SaveCommand::class),

    // Services
    'FileService' => create(FileService::class),

    // Repositories
    'FileRepository' => create(FileRepository::class),

    // Other
    'MyLogger' => create(MyLogger::class),
];
