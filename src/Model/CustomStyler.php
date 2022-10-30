<?php

namespace Panosmits\Basekit\Model;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CustomStyler extends SymfonyStyle
{
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        parent::__construct($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return CustomStyler
     */
    public static function createFromIO(InputInterface $input, OutputInterface $output): CustomStyler
    {
        return new CustomStyler($input, $output);
    }

    /**
     * Display a message in case of success.
     */
    public function successful(string $message): void
    {
        $this->block(sprintf(' 🎉  %s', $message), null, 'fg=white;bg=green', ' ', true);
    }

    /**
     * Display a message in case of failure.
     */
    public function failure(string $message): void
    {
        $this->block(sprintf(' 😮  %s', $message), null, 'fg=white;bg=red', ' ', true);
    }
}