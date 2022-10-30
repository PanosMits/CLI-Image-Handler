<?php

namespace Panosmits\Basekit\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MyLogger
{
    public Logger $logger;

    public function __construct()
    {
        $logger = new Logger('BaseKitLog');
        $fileHandler = new StreamHandler(__DIR__.'../../../app.log');
        $fileHandler->setFormatter(new LineFormatter());
        $this->logger = $logger->pushHandler($fileHandler);
    }
}