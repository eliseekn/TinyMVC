<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Make;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create new test.
 */
class Test extends Command
{
    protected static $defaultName = 'make:test';

    protected function configure(): void
    {
        $this->setDescription('Create new PHPUnit test case');
        $this->addArgument('test', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The name of test (separated by space if many)');
        $this->addOption('unit', 'u', InputOption::VALUE_NONE, 'Setup for unit test');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Specify subdirectory path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tests = $input->getArgument('test');

        foreach ($tests as $test) {
            list(, $class) = Maker::generateClass($test, 'test', true);

            if (! Maker::createTest($test, $input->getOption('unit'), $input->getOption('path'))) {
                $output->writeln('<error>[ERROR] Failed to create test "' . $class . '"</error>');
            } else {
                $output->writeln('<info>[INFO] Test "' . $class . '" has been created</info>');
            }
        }

        return Command::SUCCESS;
    }
}
