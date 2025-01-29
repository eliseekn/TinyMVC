<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Clear twig templates cache.
 */
class ClearTwigCache extends Command
{
    protected static $defaultName = 'clear:twig-cache';

    protected function configure(): void
    {
        $this->setDescription('Clear twig templates cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        storage(config('storage.cache'))->deleteDir();
        $output->writeln('<info>[INFO] Twig templates cache has been cleared</info>');

        return Command::SUCCESS;
    }
}
